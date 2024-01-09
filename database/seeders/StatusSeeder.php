<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Status::insert([
            [
                'id' => 1,
                'label' => 'Backlog',
                'color' => '#3498db', // Azul
            ],
            [
                'id' => 2,
                'label' => 'Fazendo',
                'color' => '#e74c3c', // Vermelho
            ],
            [
                'id' => 3,
                'label' => 'Pendente',
                'color' => '#f39c12', // Laranja
            ],
            [
                'id' => 4,
                'label' => 'Finalizado',
                'color' => '#2ecc71', // Verde
            ],
        ]);
    }
}
