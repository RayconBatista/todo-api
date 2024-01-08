<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $project = Project::first();
        Tag::insert([
            [
                'id'            => 1,     
                'project_id'    => $project->id,     
                'label'         => 'teste 1',
                'color'         => 'red'     
            ],
            [
                'id'            => 2,     
                'project_id'    => $project->id,
                'label'         => 'teste 2',
                'color'         => 'blue'     
            ],
            [
                'id'            => 3,     
                'project_id'    => $project->id,
                'label'         => 'teste 3',
                'color'         => 'yellow'     
            ],
        ]);
    }
}
