<?php

namespace Database\Seeders;

use App\Models\TaskStatus;
use Illuminate\Database\Seeder;

class TaskStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TaskStatus::query()->truncate();
        TaskStatus::query()->create(['name' => '下書き']);
        TaskStatus::query()->create(['name' => '着手中']);
        TaskStatus::query()->create(['name' => '保留']);
        TaskStatus::query()->create(['name' => '完了']);
    }
}
