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
        for ($CatalogID = 01; $CatalogID < 100; $CatalogID++) {
            $access = \App\Enums\IndexEnum::getValues();
            $randomAccess = $access[array_rand($access)];
            Task::query()->create([
                'catalog_id' => $CatalogID,
                'text' => fake()->sentence(),
                'description' => fake()->paragraph(),
                'position' => fake()->numberBetween(1, 5),
                'progress' => rand(0, 100),  // Giá trị ngẫu nhiên từ 0 đến 100
                'start_date' => '2024-09-14',  // Ngày cố định
                'end_date' => '2024-09-19',  // Ngày cố định
                'parent' => 0,  // Không có task cha
                'sortorder' => rand(1, 100),  // Giá trị ngẫu nhiên cho thứ tự sắp xếp
                'image' => fake()->optional()->imageUrl(),
                'priority' => $randomAccess,
                'risk' => $randomAccess,
            ]);
        }
    //     for ($TaskID = 01; $TaskID < 100; $TaskID++) {
    //         for ($UserID = 01; $UserID < 100; $UserID++) {
    //             TaskMember::query()->create([
    //                 'task_id' =>$TaskID,
    //                 'user_id' =>$UserID,
    //                 'follow' => fake()->boolean(20),
    //             ]);
    //         }
    //     }
    //     for ($TaskID = 01; $TaskID < 100; $TaskID++) {
    //         for ($UserID = 01; $UserID < 100; $UserID++) {
    //             TaskComment::query()->create([
    //                 'task_id' =>$TaskID,
    //                 'user_id' =>$UserID,
    //                 'content' => fake()->paragraph(),
    //                 'image' => fake()->optional()->imageUrl(),
    //                 'parent_id' => null,
    //             ]);
    //         }
    //     }
    //    $data=TaskComment::query()->get();
    //     for ($TaskID = 01; $TaskID < 100; $TaskID++) {
    //         for ($UserID = 01; $UserID < 100; $UserID++) {
    //             TaskComment::query()->create([
    //                 'task_id' =>$TaskID,
    //                 'user_id' =>$UserID,
    //                 'content' => fake()->paragraph(),
    //                 'image' => fake()->optional()->imageUrl(),
    //                 'parent_id' =>  $data->random()->id,
    //             ]);
    //         }
    //     }
    //     for ($TaskID = 01; $TaskID < 100; $TaskID++) {
    //         for ($UserID = 01; $UserID < 100; $UserID++) {
    //             TaskAttachment::query()->create([
    //                 'task_id' =>$TaskID,
    //                 'user_id' =>$UserID,
    //                 'file_name' => fake()->word() . '.pdf',
    //             ]);
    //         }
    //     }
    //     for ($TaskID = 01; $TaskID < 100; $TaskID++){
    //         if (fake()->boolean()){
    //             TaskLink::query()->create([
    //                 'task_id' => $TaskID,
    //                 'linkable_id' => rand(1,10),
    //                 'linkable_type' => Board::class,
    //             ]);
    //         }else{
    //             TaskLink::query()->create([
    //                 'task_id' => $TaskID,
    //                 'linkable_id' => rand(1,10),
    //                 'linkable_type' => Task::class,
    //             ]);
    //         }
    //     }


    }
}

