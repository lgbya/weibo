<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class FollowersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $user = $users->first();
        $userId = $user->id;

        $followers = $users->slice(1);
        $followersIds = $followers->pluck('id')->toArray();

        $user->follow($followersIds);

        foreach($followers as $follower){
            $follower->follow($userId);
        }
    }
}
