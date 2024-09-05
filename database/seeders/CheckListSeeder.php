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
use Illuminate\Database\Seeder;

class CheckListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $tasks = Task::all();
        $users = User::all();

        if ($tasks->isEmpty() || $users->isEmpty()) {
            return;
        }


        foreach ($tasks as $task) {
            CheckList::query()->create([
                'task_id' => $task->id,
                'name' => fake()->name(),
            ]);
        }


        $checkLists = CheckList::all();


        foreach ($checkLists as $checkList) {
            CheckListItem::query()->create([
                'check_list_id' => $checkList->id,
                'name' => fake()->sentence(3),
                'parent_id' => null,
                'is_complete' => fake()->boolean(),
                'start_date' => fake()->date(),
                'end_date' => fake()->date(),
                'reminder_date' => fake()->date(),
            ]);
        }


        $checkListItems = CheckListItem::all();


        foreach ($checkListItems as $checkListItem) {
            CheckListItemMember::query()->create([
                'check_list_item_id' => $checkListItem->id,
                'user_id' => $users->random()->id,
            ]);
        }


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


        $colors = Color::all();


        foreach ($colors as $color) {
            Label::query()->create([
                'color_id' => $color->id,
                'name' => fake()->word(),
            ]);
        }


        $labels = Label::all();
        foreach ($tasks as $task) {
            TaskLabel::query()->create([
                'task_id' => $task->id,
                'label_id' => $labels->random()->id,
            ]);
        }
    }
}
