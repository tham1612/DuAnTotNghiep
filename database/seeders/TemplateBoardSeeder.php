<?php

namespace Database\Seeders;

use App\Models\TemplateBoard;
use App\Models\TemplateCatalog;
use App\Models\TemplateCheckList;
use App\Models\TemplateCheckListItem;
use App\Models\TemplateTask;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class TemplateBoardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();


        for ($i = 01; $i < 10; $i++) {
            TemplateBoard::query()->create([
                'name' => fake()->word(),
                'description' => fake()->paragraph(),
                'image' => fake()->optional()->imageUrl(),
            ]);
        }


        $templateBoards = TemplateBoard::all();
        foreach ($templateBoards as $templateBoard){
            TemplateCatalog::query()->create([
                'template_board_id' => $templateBoard->id,
                'name' => fake()->word(),
                'image' => fake()->optional()->imageUrl(),
                'position' => fake()->numberBetween(1, 7),
            ]);
        }


        $templateCatalogs = TemplateCatalog::all();
        foreach ($templateCatalogs as $templateCatalog){
            $access = \App\Enums\IndexEnum::getValues();
            $randomAccess = $access[array_rand($access)];
            TemplateTask::query()->create([
                'template_catalog_id' => $templateCatalog->id,
                'title' => fake()->sentence(3),
                'description' => fake()->optional()->paragraph(),
                'position' => fake()->numberBetween(1, 100),
                'image' => fake()->optional()->imageUrl(),
                'priority' => $randomAccess,
                'risk' => $randomAccess,
            ]);
        }


        $templateTasks = TemplateTask::all();
        foreach ($templateTasks as $templateTask) {
            TemplateCheckList::query()->create([
                'template_task_id' => $templateTask->id,
                'name' => fake()->word(),
            ]);
        }


        $templateCheckLists = TemplateCheckList::all();
        foreach ($templateCheckLists as $templateCheckList) {

            $parentId = TemplateCheckListItem::query()->insertGetId([
                'template_check_list_id' => $templateCheckList->id,
                'name' => fake()->word(),
                'parent_id' => null,
                'is_complete' => fake()->boolean(),
            ]);


            for ($i = 0; $i < 3; $i++) {
                TemplateCheckListItem::query()->create([
                    'template_check_list_id' => $templateCheckList->id,
                    'name' => fake()->word(),
                    'parent_id' => $parentId,
                    'is_complete' => fake()->boolean(),
                ]);
            }
        }

        Schema::enableForeignKeyConstraints();
    }
}
