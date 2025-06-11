<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Article;
use Illuminate\Support\Facades\Storage;
// use Illuminate\Support\Str; // HAPUS INI

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!Storage::disk('public')->exists('articles')) {
            Storage::disk('public')->makeDirectory('articles');
        }

        $articlesData = [
            [
                'title' => 'Panduan Investasi Emas untuk Pemula',
                'category' => 'Emas',
                'body' => 'Emas adalah salah satu instrumen investasi yang paling klasik dan sering menjadi pilihan utama bagi pemula. Nilainya cenderung stabil dan berfungsi sebagai lindung nilai inflasi. Ada berbagai cara untuk berinvestasi emas, mulai dari emas fisik hingga emas digital. Penting untuk memahami perbedaan dan risikonya.',
                'image_path' => 'articles/default-emas.png',
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Memulai Investasi Saham: Yang Perlu Anda Tahu',
                'category' => 'Saham',
                'body' => 'Investasi saham menawarkan potensi keuntungan yang tinggi, tetapi juga disertai risiko yang sepadan. Sebelum terjun ke pasar saham, pelajari dasar-dasar analisis, cara membaca laporan keuangan, dan strategi diversifikasi portofolio. Jangan tergiur keuntungan instan tanpa riset mendalam.',
                'image_path' => 'articles/default-saham.jpeg',
                'published_at' => now()->subDays(10),
            ],
            [
                'title' => 'Reksadana: Alternatif Investasi Mudah untuk Semua',
                'category' => 'Reksadana',
                'body' => 'Bagi Anda yang sibuk atau kurang berpengalaman, reksadana bisa menjadi pilihan menarik. Dana Anda akan dikelola oleh manajer investasi profesional yang akan mengalokasikannya ke berbagai instrumen. Pilihlah jenis reksadana yang sesuai dengan profil risiko Anda, seperti reksadana pasar uang, pendapatan tetap, atau saham.',
                'image_path' => 'articles/default-reksadana.jpg',
                'published_at' => now()->subDays(15),
            ],
            [
                'title' => 'Memahami Fluktuasi Pasar Kripto',
                'category' => 'Kripto',
                'body' => 'Pasar kripto dikenal dengan volatilitasnya yang tinggi. Meskipun menawarkan potensi keuntungan eksponensial, risikonya juga sangat besar. Penting untuk tidak menginvestasikan lebih dari yang Anda mampu untuk kehilangan dan selalu melakukan riset mendalam sebelum membeli aset kripto apapun.',
                'image_path' => 'articles/default-kripto.jpg',
                'published_at' => now()->subDays(20),
            ],
            [
                'title' => 'Tips Mengelola Risiko dalam Trading Forex',
                'category' => 'Trading',
                'body' => 'Trading Forex adalah aktivitas jual beli mata uang asing dengan tujuan mencari keuntungan dari selisih kurs. Pasar Forex adalah pasar terbesar di dunia dan beroperasi 24 jam sehari. Namun, tingginya leverage dan volatilitas membuatnya menjadi instrumen yang sangat berisiko. Manajemen risiko adalah kunci utama untuk bertahan di pasar ini.',
                'image_path' => 'articles/default-forex.jpg',
                'published_at' => null,
            ],
        ];

        foreach ($articlesData as $articleData) {
            // HAPUS LOGIKA SLUG DI SINI
            // $articleData['slug'] = Str::slug($articleData['title']);

            Article::updateOrCreate(
                ['title' => $articleData['title']],
                $articleData // Pastikan array tidak lagi mengandung 'slug'
            );
        }
    }
}