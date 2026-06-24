<?php

namespace App\Controllers;

class Page extends BaseController
{
    public function about()
    {
        return view('about', [
            'title' => 'Halaman About',
            'content' => 'Ini adalah halaman About yang menjelaskan tentang isi halaman ini.'
        ]);
    }

    public function contact()
    {
        return view('contact', [
            'title' => 'Contact',
            'content' => 'Ini adalah halaman Contact.'
        ]);
    }

    public function faqs()
    {
        return view('faqs', [
            'title' => 'FAQs',
            'content' => 'Ini adalah halaman FAQs.'
        ]);
    }

    public function getTos()
    {
        return view('tos', [
            'title' => 'Terms of Service',
            'content' => 'Ini adalah halaman Terms of Service.'
        ]);
    }

    public function artikel()
    {
    return view('artikel', [
        'title' => 'Artikel',
        'content' => 'Ini adalah halaman Artikel.'
    ]);
    }
}