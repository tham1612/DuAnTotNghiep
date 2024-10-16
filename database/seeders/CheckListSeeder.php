<?php

namespace Database\Seeders;

use App\Models\CheckList;
use App\Models\CheckListItem;
use App\Models\CheckListItemMember;
use App\Models\Color;
use App\Models\Label;
use App\Models\Task;
use App\Models\TaskLabel;
use App\Models\User;
use DB;
use Illuminate\Database\Seeder;

class CheckListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tasks = Task::all();
        
        $colors = [
            ['name' => 'Red', 'code' => '#FF0000'],
            ['name' => 'Green', 'code' => '#00FF00'],
            ['name' => 'Blue', 'code' => '#0000FF'],
            ['name' => 'Yellow', 'code' => '#FFFF00'],
            ['name' => 'Cyan', 'code' => '#00FFFF'],
            ['name' => 'Magenta', 'code' => '#FF00FF'],
            ['name' => 'Black', 'code' => '#000000'],
            ['name' => 'White', 'code' => '#FFFFFF'],
        ];


        foreach ($colors as $color) {
            Color::query()->create([
                'name' => $color['name'],
                'code' => $color['code'],
            ]);
        }

        $users = User::all();

        if ($tasks->isEmpty() || $users->isEmpty()) {
            return;
        }

        // Thêm CheckList
        foreach ($tasks as $task) {
            DB::table('check_lists')->insert([
                'task_id' => $task->id,
                'name' => fake()->text(30),
            ]);
        }

        // Lấy tất cả check_lists
        $checkLists = DB::table('check_lists')->get();

        // Thêm CheckListItem
        foreach ($checkLists as $checkList) {
            DB::table('check_list_items')->insert([
                'check_list_id' => $checkList->id,
                'name' => fake()->sentence(3),
                'parent_id' => null,
                'is_complete' => fake()->boolean(),
                'start_date' => fake()->date(),
                'end_date' => fake()->date(),
                'reminder_date' => fake()->date(),
            ]);
        }

        // Lấy tất cả check_list_items
        $checkListItems = DB::table('check_list_items')->get();

        // Thêm CheckListItemMember
        foreach ($checkListItems as $checkListItem) {
            DB::table('check_list_item_members')->insert([
                'check_list_item_id' => $checkListItem->id,
                'user_id' => $users->random()->id,
            ]);
        }
    }
}