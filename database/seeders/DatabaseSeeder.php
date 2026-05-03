<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use App\Models\Member;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin & Petugas
        User::firstOrCreate(['email' => 'admin@perpus.com'], [
            'name'     => 'Administrator',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        User::firstOrCreate(['email' => 'petugas@perpus.com'], [
            'name'     => 'Petugas Perpustakaan',
            'password' => Hash::make('password'),
            'role'     => 'petugas',
        ]);

        // Categories
        $categories = ['Fiksi', 'Non-Fiksi', 'Sains & Teknologi', 'Sejarah', 'Biografi', 'Pendidikan', 'Agama', 'Komik'];
        foreach ($categories as $cat) {
            Category::firstOrCreate(['name' => $cat], ['slug' => \Illuminate\Support\Str::slug($cat)]);
        }

        if (Book::count() > 0) return; // skip if already seeded

        // Books
        $books = [
            ['Laskar Pelangi', 'Andrea Hirata', '9789793062792', 1, 'Bentang Pustaka', 2005, 5],
            ['Bumi Manusia', 'Pramoedya Ananta Toer', '9789799731234', 1, 'Hasta Mitra', 1980, 3],
            ['Atomic Habits', 'James Clear', '9780735211292', 3, 'Avery', 2018, 4],
            ['Sapiens', 'Yuval Noah Harari', '9780062316097', 4, 'Harper', 2011, 3],
            ['Clean Code', 'Robert C. Martin', '9780132350884', 3, 'Prentice Hall', 2008, 2],
            ['Harry Potter', 'J.K. Rowling', '9780439708180', 1, 'Scholastic', 1997, 6],
            ['Sejarah Indonesia Modern', 'M.C. Ricklefs', '9789794611234', 4, 'Gadjah Mada UP', 2001, 2],
            ['Matematika Dasar', 'Tim Dosen', null, 6, 'Erlangga', 2020, 8],
        ];

        foreach ($books as [$title, $author, $isbn, $catId, $publisher, $year, $stock]) {
            Book::create([
                'title'          => $title,
                'author'         => $author,
                'isbn'           => $isbn,
                'category_id'    => $catId,
                'publisher'      => $publisher,
                'published_year' => $year,
                'stock'          => $stock,
                'total_stock'    => $stock,
            ]);
        }

        // Members + User akun peminjam demo
        $members = [
            ['Budi Santoso',  'budi@email.com',  '081234567890', 'male'],
            ['Siti Rahayu',   'siti@email.com',  '082345678901', 'female'],
            ['Ahmad Fauzi',   'ahmad@email.com', '083456789012', 'male'],
            ['Dewi Lestari',  'dewi@email.com',  '084567890123', 'female'],
            ['Rizky Pratama', 'rizky@email.com', '085678901234', 'male'],
        ];

        foreach ($members as $i => [$name, $email, $phone, $gender]) {
            User::firstOrCreate(['email' => $email], [
                'name'     => $name,
                'phone'    => $phone,
                'password' => Hash::make('password'),
                'role'     => 'peminjam',
            ]);

            Member::firstOrCreate(['email' => $email], [
                'member_code'      => 'MBR-' . str_pad($i + 1, 5, '0', STR_PAD_LEFT),
                'name'             => $name,
                'email'            => $email,
                'phone'            => $phone,
                'gender'           => $gender,
                'status'           => 'active',
                'membership_expiry'=> now()->addYear(),
            ]);
        }
    }
}
