<?php

namespace Database\Seeders;

use App\Enums\AccessEnum;
use App\Models\User;
use App\Models\Workspace;
use App\Models\WorkspaceMember;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class WorkspaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        for ($i = 1; $i <= 10; $i++) {
            $name = fake()->name(); 
            $email = strtolower(str_replace(' ', '.', $name)) . '@gmail.com';

            // Tạo user với email duy nhất
            User::create([
                'name' => $name,
                'email' => $email,
                'password' => '12345678',
                'phone' => fake()->phoneNumber(),
                'address' => fake()->address(),
            ]);
        }
        
        for ($i = 01; $i < 10; $i++) {
            $name = fake()->text(30);
            $description = fake()->text(200);
            $access = \App\Enums\AccessEnum::getValues();
            $randomAccess = $access[array_rand($access)];
            $slug = Str::slug($name, '-');
            $domain = fake()->domainName();
            $link_invite = "https://{$domain}/{$slug}";
            Workspace::query()->create([
                'name' => $name,
                'description' => $description,
                'access' => $randomAccess,
                'image' => fake()->optional()->imageUrl(),
                'link_invite' => $link_invite
            ]);
        }
        for ($userID  = 01; $userID  < 10; $userID ++){
            for ($WorkspaceID  = 1; $WorkspaceID  < 10; $WorkspaceID ++){
                $authorize = \App\Enums\AuthorizeEnum::getValues();
                $randomAuthorize = $authorize[array_rand($authorize)];
                WorkspaceMember::query()->create([
                    'user_id'=>$userID,
                    'workspace_id'=>$WorkspaceID,
                    'authorize'=> $randomAuthorize,
                    'is_active' => 1,
                    'invite'=>fake()->date(),
                ]);

            }
        }

    }
}
