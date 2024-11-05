<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Faq;
use App\Models\Help;

class HomeController extends Controller
{
    // Menampilkan halaman FAQ utama
    public function index()
    {
        // Fetch only FAQ categories
        $categories = Category::whereIn('slug', ['akun', 'aplikasi', 'pengaduan'])->get();
        return view('faq', compact('categories'));
    }

    // Menampilkan FAQ berdasarkan kategori
    public function showCategory($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $faqs = Faq::where('category_id', $category->id)->get();
        return view('faq.category', compact('category', 'faqs'));
    }

    // Menampilkan halaman Help utama
    public function indexHelp()
    {
        // Fetch only Help categories
        $helpTopics = Category::whereIn('slug', ['tiket', 'jaringan', 'software', 'hardware'])->get();
        return view('help', compact('helpTopics'));
    }

    // Menampilkan Help berdasarkan kategori
    public function showCategoryHelp($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $helps = Help::where('category_id', $category->id)->get();
        return view('help.category', compact('category', 'helps'));
    }
}
