<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Tiket</title>
    <link rel="icon" href="{{ asset('img/logo-kemhan.png') }}" type="image/png">  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        .card-header {
            background-color: #007bff;
            color: white;
        }
        /* Styling message bubbles */
        .message-left, .message-right {
            display: inline-block;
            padding: 10px;
            border-radius: 10px;
            margin: 5px 0;
            max-width: 70%;
            word-wrap: break-word;
            clear: both;
        }
        .message-left {
            background-color: #f1f1f1;
            text-align: left;
            float: left;
        }
        .message-right {
            background-color: #d1ecf1;
            text-align: right;
            float: right;
        }
        .chat-container {
            max-height: 300px;
            overflow-y: auto;
            padding: 10px;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            background-color: #ffffff;
        }
    </style>
</head>
<body>
    <nav class="navbar bg-body-dark">
        <form class="container-fluid justify-content-left mt-4 ms-2">
          <button onclick="history.back()" class="btn btn-outline-danger me-2" type="button">Back</button>
        </form>
    </nav>
    <div class="container mt-5">
        <div class="card mb-5">
            <div class="card-header">
                <h5 class="mb-0">Detail Tiket</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered table-hover mt-3">
                    <tr>
                        <th style="width: 20%;">Subjek</th>
                        <td>{{ $tiket->subjek }}</td>
                    </tr>
                    <tr>
                        <th>Permasalahan</th>
                        <td>{{ $tiket->permasalahan }}</td>
                    </tr>
                    <tr>
                        <th>Satker</th>
                        <td>{{ $tiket->satkerData->nama_satker ?? 'Satker tidak ditemukan' }}</td>
                    </tr>               
                    <tr>
                        <th>Prioritas</th>
                        <td>{{ $tiket->prioritas }}</td>
                    </tr>
                    <tr>
                        <th>Area Laporan</th>
                        <td>{{ $tiket->area }}</td>
                    </tr>
                    <tr>
                        <th>Pesan</th>
                        <td>{!! $tiket->pesan !!}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Dibuat</th>
                        <td>{{ $tiket->created_at->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <th>Lampiran</th>
                        <td>
                            @if ($tiket->lampiran)
                                @php
                                    $filePath = str_replace('public/', '', $tiket->lampiran);
                                    $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                                    $filename = 'Lampiran.' . $extension;
                                    $isImage = in_array($extension, ['jpg', 'jpeg', 'png']);
                                    $isPDF = $extension === 'pdf';
                                @endphp
                                <!-- Show Image or PDF Preview -->
                                @if ($isImage)
                                    <a href="{{ asset('storage/' . $filePath) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $filePath) }}" alt="Lampiran" style="max-width: 200px; max-height: 200px;">
                                    </a>
                                @elseif ($isPDF)
                                    <embed src="{{ asset('storage/' . $filePath) }}" type="application/pdf" width="100%" height="400px" />
                                @endif
                    
                                <!-- Always show the download button -->
                                <br>
                                <a href="{{ asset('storage/' . $filePath) }}" target="_blank" download="{{ $filename }}">Unduh {{ $filename }}</a>
                            @else
                                <span class="text-muted">Tidak ada lampiran</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="card mb-5">
            <div class="card-header">
                <h5 class="mb-0">Diskusi</h5>
            </div>
            <div class="card-body">
                <div id="chat-messages" class="chat-container">
                    <!-- Messages will be loaded dynamically -->
                </div>
                <form id="chat-form" class="mt-3" enctype="multipart/form-data">
                    <div class="input-group">
                        <!-- Tombol untuk Attachment dengan Ikon -->
                        <button type="button" class="btn btn-outline-secondary" onclick="document.getElementById('chat-lampiran').click();">
                            <i class="fas fa-paperclip"></i> <!-- Ikon attachment -->
                        </button>
                        
                        <!-- Input Tersembunyi untuk File -->
                        <input type="file" id="chat-lampiran" class="d-none">
                        
                        <!-- Input untuk Pesan Chat -->
                        <input type="text" id="chat-input" class="form-control" placeholder="Ketik pesan..." required>
                        
                        <!-- Tombol Kirim Pesan -->
                        <button type="submit" class="btn btn-primary">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Tambahkan link Font Awesome di <head> atau pada halaman ini jika belum tersedia -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const loggedInUserId = {{ auth()->id() }};
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function loadChatMessages() {
                fetch("/tiket/chat-messages/{{ $tiket->id }}")
                    .then(response => response.json())
                    .then(data => {
                        const chatMessages = document.getElementById("chat-messages");
                        chatMessages.innerHTML = "";
                        data.messages.forEach(message => {
                            const messageElement = document.createElement("div");

                            if (message.user_id === loggedInUserId) {
                                messageElement.classList.add("message-right");
                            } else {
                                messageElement.classList.add("message-left");
                                messageElement.innerHTML = `<strong>${message.user_name}</strong><br>`;
                            }
                            
                            messageElement.innerHTML += `${message.content}`;
                            if (message.lampiran) {
                                messageElement.innerHTML += `<br><a href="${message.lampiran}" target="_blank" download>Unduh</a>`;
                            }
                            messageElement.innerHTML += `<div class="text-muted" style="font-size: 0.8em; margin-top: 4px;">${message.created_at}</div>`;
                            
                            chatMessages.appendChild(messageElement);
                        });
                        chatMessages.scrollTop = chatMessages.scrollHeight;
                    }); 
            }

            loadChatMessages();

            document.getElementById("chat-form").addEventListener("submit", function(e) {
            e.preventDefault();
            const chatInput = document.getElementById("chat-input");
            const chatLampiran = document.getElementById("chat-lampiran");

            // Create FormData to include text and file data
            const formData = new FormData();
            formData.append("tiket_id", {{ $tiket->id }});
            formData.append("content", chatInput.value);
            if (chatLampiran.files[0]) {
                formData.append("lampiran", chatLampiran.files[0]);
            }

            fetch("/tiket/send-message", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: formData
            }).then(() => {
                chatInput.value = "";
                chatLampiran.value = "";
                loadChatMessages();
            });
        });
        });
    </script>
</body>
</html>
