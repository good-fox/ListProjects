<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call(UsersTableSeeder::class);


        factory(App\User::class, $users = 10)->create()->each(function($user) {

            $user->project()->saveMany(
            factory(App\Project::class, $projects_of_user = rand(7,18))->create(array('user_id' => $user->id))->each(function ($project){

                $project->task()->saveMany(
                factory(App\Task::class, $tasks_of_project = rand(12,24))->make());
            }));
        });
    }
}
