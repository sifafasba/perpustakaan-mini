<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@perpus.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin'
        ]);

        // Create User
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@mail.com',
            'password' => Hash::make('user123'),
            'role' => 'user'
        ]);

        User::create([
            'name' => 'Siti Nurhaliza',
            'email' => 'siti@mail.com',
            'password' => Hash::make('user123'),
            'role' => 'user'
        ]);

        // Create Categories
        $categories = [
            ['name' => 'Fiksi', 'description' => 'Buku cerita fiksi'],
            ['name' => 'Non-Fiksi', 'description' => 'Buku pengetahuan umum'],
            ['name' => 'Teknologi', 'description' => 'Buku tentang teknologi dan programming'],
            ['name' => 'Sejarah', 'description' => 'Buku sejarah dan biografi'],
            ['name' => 'Sains', 'description' => 'Buku ilmu pengetahuan'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create Books
        $books = [
            [
                'title' => 'Laskar Pelangi',
                'author' => 'Andrea Hirata',
                'year' => 2005,
                'stock' => 5,
                'category_id' => 1,
                'isbn' => '978-979-442-975-1',
                'description' => 'Novel tentang perjuangan anak-anak Belitung'
            ],
            [
                'title' => 'Bumi Manusia',
                'author' => 'Pramoedya Ananta Toer',
                'year' => 1980,
                'stock' => 3,
                'category_id' => 1,
                'isbn' => '978-979-8992-91-6',
                'description' => 'Tetralogi Buru - Novel sejarah Indonesia'
            ],
            [
                'title' => 'Clean Code',
                'author' => 'Robert C. Martin',
                'year' => 2008,
                'stock' => 4,
                'category_id' => 3,
                'isbn' => '978-0-13-235088-4',
                'description' => 'A Handbook of Agile Software Craftsmanship'
            ],
            [
                'title' => 'Sejarah Indonesia Modern',
                'author' => 'M.C. Ricklefs',
                'year' => 1981,
                'stock' => 2,
                'category_id' => 4,
                'isbn' => '978-979-469-299-4',
                'description' => 'Sejarah Indonesia sejak tahun 1200'
            ],
            [
                'title' => 'Sapiens',
                'author' => 'Yuval Noah Harari',
                'year' => 2011,
                'stock' => 6,
                'category_id' => 5,
                'isbn' => '978-0-06-231609-7',
                'description' => 'A Brief History of Humankind'
            ],
            [
                'title' => 'Laravel Up & Running',
                'author' => 'Matt Stauffer',
                'year' => 2019,
                'stock' => 3,
                'category_id' => 3,
                'isbn' => '978-1-4919-3695-2',
                'description' => 'A Framework for Building Modern PHP Apps'
            ],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
    }
}
