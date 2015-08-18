<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call('UsersTableSeeder');
        $this->call('TutorsTableSeeder');
        $this->call('ReviewsTableSeeder');
        $this->call('SchoolsTableSeeder');
        $this->call('SchoolSubjectsTableSeeder');
        $this->call('TutorSchoolsTableSeeder');
        $this->call('ClassesTableSeeder');
        $this->call('LevelsTableSeeder');
        $this->call('TutorLevelsTableSeeder');
        $this->call('TutorMusicTableSeeder');
        Model::reguard();
    }
}
