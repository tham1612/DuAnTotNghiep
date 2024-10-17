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
            ['name' => 'xanh nhạt', 'code' => '#CCF2D9'],
            ['name' => 'vàng nhạt', 'code' => '#F6E8B1'],
            ['name' => 'kem', 'code' => '#FAD9C1'],
            ['name' => 'hồng nhạt', 'code' => '#F7C6C7'],
            ['name' => 'tím nhạt', 'code' => '#E3D7FF'],
            ['name' => 'xanh ngọc', 'code' => '#47C9AF'],
            ['name' => 'vàng tươi', 'code' => '#F6D365'],
            ['name' => 'cam nhạt', 'code' => '#F8A978'],
            ['name' => 'xanh nhạt', 'code' => '#F76F72'],
            ['name' => 'đỏ cam', 'code' => '#F6E8B1'],
            ['name' => 'tím', 'code' => '#9B88FF'],
            ['name' => 'xanh lá cây đậm', 'code' => '#207561'],
            ['name' => 'vàng nâu', 'code' => '#A67F00'],
            ['name' => 'cam đậm', 'code' => '#DC4D01'],
            ['name' => 'đỏ', 'code' => '#E53935'],
            ['name' => 'tím đậm', 'code' => '#6B4E9B'],
            ['name' => 'xanh dương nhạt', 'code' => '#C1D7FF'],
            ['name' => 'xanh dương', 'code' => '#B0E4FF'],
            ['name' => 'xanh lá cây nhạt', 'code' => '#D8EF99'],
            ['name' => 'xanh dương sáng', 'code' => '#D3D3D3'],
            ['name' => 'xanh biển', 'code' => '#47C6E8'],
            ['name' => 'xanh lá cây sáng', 'code' => '#A9D046'],
            ['name' => 'hồng', 'code' => '#E84E82'],
            ['name' => 'xám xanh', 'code' => '#697689'],
            ['name' => 'xanh dương đậm', 'code' => '#0052CC'],
            ['name' => 'xanh ngọc đậm', 'code' => '#1B6C71'],
            ['name' => 'xanh lá cây đậmm', 'code' => '#4C6B41'],
            ['name' => 'hồng tím', 'code' => '#A64D79'],
            ['name' => 'xám đậm', 'code' => '#4F5B66'],
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
