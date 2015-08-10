<?php

use Illuminate\Database\Seeder;

class SchoolSubjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      $schools = App\School::where('id', '!=', 1)->get();
      //some random subjects
      $subjects = ['Math', 'Science', 'English', 'History', 'Social Studies', 'French', 'Spanish', 'Physics', 'German', 'Mandarin', 'Computer Science', 'Engineering'];

      $schools->each(function($u) use($subjects){
        //figure out how many subjects
        $num = rand(1, count($subjects));
        for ($i =0; $i < $num; $i++)
        {
          $rand_subject = $subjects[rand(0, count($subjects)-1)];
          //check to make sure subject doesnt already exists
          if (!$u->subjects()->where('subject_name', $rand_subject)->get()->isEmpty()) continue;
          $u->subjects()->create(['subject_name' => $rand_subject]);
        }
      });

    }
}
