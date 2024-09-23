<?php

namespace Database\Seeders;

use App\Models\Board;
use App\Models\BoardMember;
use App\Models\Catalog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class BoardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        for ($WorkspaceID = 1; $WorkspaceID < 10; $WorkspaceID++) {
            $name = fake()->text(100);
            $description = fake()->text(200);
            $access = \App\Enums\AccessEnum::getValues();
            $randomAccess = $access[array_rand($access)];
            $slug = Str::slug($name, '-');

            $link_invite = "https://example.com/{$slug}";
            Board::query()->create([
                'workspace_id' => $WorkspaceID,
                'access' => $randomAccess,
                'name' => $name,
                'description' => $description,
                'image' => fake()->imageUrl(),
                'comment_rights' => fake()->boolean(),
                'add_delete_rights' => fake()->boolean(),
                'edit_workspace' => fake()->boolean(),
                'link_invite' => $link_invite,
                'complete' => fake()->numberBetween(0, 100),
            ]);
        }
        for ($userID = 1; $userID < 10; $userID++) {
            for ($BoardID = 1; $BoardID < 10; $BoardID++) {
                $authorize = \App\Enums\AuthorizeEnum::getValues();
                $randomAuthorize = $authorize[array_rand($authorize)];
                BoardMember::query()->create([
                    'user_id' => $userID,
                    'board_id' => $BoardID,
                    'authorize' => $randomAuthorize,
                    'is_star' => fake()->boolean(10),
                    'follow' => fake()->boolean(50),
                    'invite' => fake()->date(),
                ]);
            }
            for ($BoardID = 1; $BoardID < 10; $BoardID++) {
                Catalog::query()->create([
                    'board_id' => $BoardID,
                    'name' => fake()->text(10),
                    'image' => fake()->optional()->imageUrl(),
                    'position' => fake()->numberBetween(1, 5),
                ]);
            }
        }

    }
}
