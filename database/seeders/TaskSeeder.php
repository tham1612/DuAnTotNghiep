<?php

namespace Database\Seeders;

use App\Models\Board;
use App\Models\Task;
use App\Models\TaskAttachment;
use App\Models\TaskComment;
use App\Models\TaskLink;
use App\Models\TaskMember;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        // Truncate để xóa dữ liệu cũ trước khi seed
        TaskMember::truncate();
        TaskComment::truncate();
        TaskAttachment::truncate();
        TaskLink::truncate();
        Task::truncate();

        Schema::enableForeignKeyConstraints();

        for ($CatalogID = 1; $CatalogID < 10; $CatalogID++) {
            $access = \App\Enums\IndexEnum::getValues();
            $randomAccess = $access[array_rand($access)];
            Task::query()->create([
                'catalog_id' => $CatalogID,
                'text' => fake()->sentence(),
                'description' => fake()->paragraph(),
                'position' => fake()->numberBetween(1, 5),
                'progress' => rand(0, 100),
                'start_date' => '2024-10-20',
                'end_date' => '2024-10-30',
                'reminder_date' => '2024-10-27',
                'parent' => 0,
                'sortorder' => rand(1, 10),
                'image' => fake()->optional()->imageUrl(),
                'priority' => $randomAccess,
                'risk' => $randomAccess,
            ]);
        }

        for ($TaskID = 1; $TaskID < 10; $TaskID++) {
            for ($UserID = 1; $UserID < 10; $UserID++) {
                // Kiểm tra nếu đã tồn tại task_id và user_id trong bảng task_members
                $exists = TaskMember::where('task_id', $TaskID)
                                    ->where('user_id', $UserID)
                                    ->exists();

                if (!$exists) {
                    TaskMember::create([
                        'task_id' => $TaskID,
                        'user_id' => $UserID,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }


        for ($TaskID = 1; $TaskID < 5; $TaskID++) {
            for ($UserID = 01; $UserID < 5; $UserID++) {
                TaskComment::query()->create([
                    'task_id' =>$TaskID,
                    'user_id' =>$UserID,
                    'content' => fake()->paragraph(),
                    'image' => fake()->optional()->imageUrl(),
                    'parent_id' => null,
                ]);
            }
        }
        for ($TaskID = 1; $TaskID < 5; $TaskID++) {
                TaskAttachment::query()->create([
                    'task_id' =>$TaskID,
                    'file_name' => fake()->word() . '.pdf',
                ]);
        }
        for ($TaskID = 01; $TaskID < 5; $TaskID++){
            if (fake()->boolean()){
                TaskLink::query()->create([
                    'task_id' => $TaskID,
                    'linkable_id' => rand(1,10),
                    'linkable_type' => Board::class,
                ]);
            }else{
                TaskLink::query()->create([
                    'task_id' => $TaskID,
                    'linkable_id' => rand(1,10),
                    'linkable_type' => Task::class,
                ]);
            }
        }
    }
}

