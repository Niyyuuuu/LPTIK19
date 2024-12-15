<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Tiket</title>
    <link rel="icon" href="{{ asset('img/logo-kemhan.png') }}" type="image/png">  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
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
    @if (session('success'))
        <div id="success-alert" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="container mt-5">
        <div class="card mb-5">
            <div class="card-header">
                <h5 class="mb-0">Detail Tiket</h5>
            </div>
            <div class="card-body">
                @php
                    function toRoman($month) {
                        $romanMonths = [
                            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V',
                            6 => 'VI', 7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X',
                            11 => 'XI', 12 => 'XII'
                        ];
                        return $romanMonths[$month] ?? '';
                    }
                @endphp
                <table class="table table-striped table-bordered table-hover mt-3">
                    <tr>
                        <th style="width: 20%;">No. Tiket</th>
                        <td>{{ str_pad($tiket->id, 6, '0', STR_PAD_LEFT) . '/' . toRoman(date('n')) . '/' . date('Y') }}</td>
                    </tr>
                    <tr>
                        <th style="width: 20%;">Subjek</th>
                        <td>{{ $tiket->subjek }}</td>
                    </tr>
                    <tr>
                        <th>Pelapor</th>
                        <td>{{ $tiket->user->name ?? 'Tanpa Nama' }}</td>
                    </tr>
                    <tr>
                        <th>Permasalahan</th>
                        <td>{{ $tiket->permasalahanData->deskripsi ?? 'Permasalahan tidak ditemukan' }}</td>
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
                        <th>Teknisi</th>
                        <td>{{ $tiket->technician ? $tiket->technician->name : 'Teknisi belum ditugaskan.' }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>{{ $tiket->statusData->name }}</td>
                    </tr>
                    <tr>
                        <th>Rating</th>
                        <td class="text-warning">
                                @for ($i = 0; $i < $tiket->rating; $i++)
                                    <i class="bx bxs-star"></i>
                                @endfor
                        </td>                        
                    </tr>
                    <tr>
                        <th>Komentar Rating</th>
                        <td>{{ $tiket->rating_comment ?? 'Komentar belum tersedia.' }}</td>
                    </tr>
                    <tr>
                        <th>Lampiran</th>
                        <td>
                            @if ($tiket->lampiran)
                                @php
                                    $filePath = str_replace('public/', '', $tiket->lampiran);
                                    $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                                    $filename = 'Lampiran.' . $extension;
                                @endphp
                                <a href="{{ asset('storage/' . $filePath) }}" target="_blank" download="{{ $filename }}">Unduh {{ $filename }}</a>
                            @else
                                <span class="text-muted">Tidak ada lampiran</span>
                            @endif
                        </td>
                    </tr>
                    @if ($tiket->status_id == 3)
                    <form action="{{ route('tickets.reprocess', $tiket->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary" onclick="return confirm('Apakah Anda yakin ingin memproses kembali tiket ini?')">Proses Kembali</button>
                    </form>                    
                        
                    @endif
                </table>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="card mb-5">
            <div class="card-header">
                <h5 class="mb-0">Diskusi Pengaduan</h5>
            </div>
            <div class="card-body">
                <div id="chat-messages" class="chat-container">
                </div>
                <form id="chat-form" class="mt-3" enctype="multipart/form-data">
                    <div class="input-group">
                        <button type="button" class="btn btn-outline-secondary" onclick="document.getElementById('chat-lampiran').click();">
                            <i class="fas fa-paperclip"></i>
                        </button>
                        <input type="file" id="chat-lampiran" class="d-none">
                        <input type="text" id="chat-input" class="form-control" placeholder="Ketik pesan...">
                        <button type="submit" class="btn btn-primary">Kirim</button>
                    </div>
                    <div id="file-preview" class="mt-2"></div>
                </form>
            </div>
        </div>
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const loggedInUserId = {{ auth()->id() }};
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
        const chatMessages = document.getElementById("chat-messages");
        const chatForm = document.getElementById("chat-form");
        const chatInput = document.getElementById("chat-input");
        const chatLampiran = document.getElementById("chat-lampiran");
        const filePreview = document.getElementById("file-preview");
        const ticketStatus = parseInt("{{ $tiket->status_id }}");

        // Load messages
        function loadChatMessages() {
            fetch(`{{url('tiket/chat-messages') }}/{{ $tiket->id }}`)
                .then(response => response.json())
                .then(data => {
                    chatMessages.innerHTML = "";
                    data.messages.forEach(message => {
                        const messageElement = document.createElement("div");
                        messageElement.classList.add(message.user_id === loggedInUserId ? "message-right" : "message-left");

                        if (message.user_id !== loggedInUserId) {
                            messageElement.innerHTML = `<strong>${message.user_name}</strong><br>`;
                        }

                        messageElement.innerHTML += message.content;

                        if (message.lampiran) {
                            messageElement.innerHTML += `<br><a href="${message.lampiran}" target="_blank" download>Unduh Dokumen</a>`;
                        }

                        messageElement.innerHTML += `<div class="text-muted" style="font-size: 0.8em; margin-top: 4px;">${message.created_at}</div>`;
                        chatMessages.appendChild(messageElement);
                    });
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                })
                .catch(err => console.error("Error loading messages:", err));
        }

        // File input preview
        chatLampiran.addEventListener("change", function () {
            const file = this.files[0];
            filePreview.innerHTML = "";

            if (file) {
                const fileName = document.createElement("span");
                fileName.textContent = `Lampiran: ${file.name}`;
                fileName.classList.add("badge", "bg-primary", "text-white", "me-2");

                const cancelButton = document.createElement("button");
                cancelButton.textContent = "Hapus";
                cancelButton.classList.add("btn", "btn-sm", "btn-danger");
                cancelButton.addEventListener("click", function () {
                    chatLampiran.value = "";
                    filePreview.innerHTML = "";
                });

                filePreview.appendChild(fileName);
                filePreview.appendChild(cancelButton);
            }
        });

        // Form submission
        chatForm.addEventListener("submit", function (e) {
            e.preventDefault();

            if (ticketStatus !== 2) {
                alert("Tidak dapat mengirim pesan pada tiket ini.");
                return;
            }

            const formData = new FormData();
            formData.append("tiket_id", "{{ $tiket->id }}");
            formData.append("content", chatInput.value);
            if (chatLampiran.files[0]) {
                formData.append("lampiran", chatLampiran.files[0]);
            }

            fetch("{{ url('tiket/send-message') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                },
                body: formData,
            })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(data => Promise.reject(data));
                    }
                    return response.json();
                })
                .then(() => {
                    chatInput.value = "";
                    chatLampiran.value = "";
                    filePreview.innerHTML = "";
                    loadChatMessages();
                })
                .catch(err => {
                    console.error("Error:", err);
                    alert(err.error || "Terjadi kesalahan saat mengirim pesan.");
                });
        });

        // Initialize chat only if ticket status is open
        if (ticketStatus === 2) {
            loadChatMessages();
        } else {
            chatForm.innerHTML = '<div class="alert alert-warning">Tidak dapat mengirim pesan karena status tiket ini tidak aktif.</div>';
        }
    });

    </script>
    <script>
        
    </script>
</body>
</html>