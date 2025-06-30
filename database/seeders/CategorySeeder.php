<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Śniadania',
            'Przekąski',
            'Desery',
            'Zupy',
            'Dania główne',
            'Sałatki',
            'Napoje bezalkoholowe',
            'Drinki',
            'Sosy i dodatki'
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['name' => $category],
                ['slug' => Str::slug($category)]
            );
        }
    }
}
