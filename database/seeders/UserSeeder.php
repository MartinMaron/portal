<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fileContent = Storage::disk('local')->get('ii_us.json');
        $users = json_decode($fileContent);
        foreach ($users as $key => $value) {
            if (!User::where('email', $value->email)->exists()) {
                $user = User::create([
                    'name' => $value->name,
                    'email' => $value->email,
                    'password' => Hash::make($value->password),
                    'current_team_id' => $value->current_team_id,
                    'isAdmin' => 1,
                    'isMieter' => 1,
                    'isUser' => 1,
                ]);

                $token = $user->createToken('auth_token')->plainTextToken;
                $user->apiToken = $token;
                $user->save();
            } else {
                User::where('email', $value->email)->update([
                    'name' => $value->name,
                    'current_team_id' => $value->current_team_id,
                    'isAdmin' => 1,
                    'isMieter' => 1,
                    'isUser' => 1,
                ]);
            }
        }

        if (!User::where('email', 'user@example.com')->exists()) {
            $testUser = User::create([
                "name" => "Testnutzer",
                "email" => "user@example.com",
                "password" => Hash::make("passwort"),
                "isAdmin" => 0,
                "isMieter" => 1,
                "isUser" => 1,
            ]);

            $testUser->apiToken = $testUser->createToken('auth_token')->plainTextToken;
            $testUser->save();
        }
    }
}

        /*
            $hashedPassword = Hash::make("nnnnnnnn");
            User::create([
                "name" => "argor",
                "email" => "argor123@freenet.de",
                "password" => $hashedPassword,
                "isAdmin" => 0,
                "isMieter" => 1,
                "isUser" => 0,
            ]);
            User::create([
                "name" => "argor",
                "email" => "argor122@e-neko.de",
                "password" => $hashedPassword,
                "isAdmin" => 0,
                "isMieter" => 1,
                "isUser" => 0,
            ]);
            if (Hash::check('nnnnnnnn', $hashedPassword))
            {
              //  dd($hashedPassword);
                // The passwords match...
            }
        */
