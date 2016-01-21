<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Models\MiddleSubject\MiddleSubject;

class InsertGlobalMiddleClasses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      $subjects = array('math' => 'Math', 'english' => 'English', 'science' => 'Science', 'social' => 'Social Studies', 'french' => 'French', 'spanish' => 'Spanish');

      $english_classes["analytical_essay"] = new stdClass;
      $english_classes["analytical_essay"]->name = "Analytical Essays";
      $english_classes["analytical_essay"]->levels[2] = "Middle School";
      $english_classes["analytical_essay"]->levels[1] = "Elementary School";

      $english_classes["memoir"] = new stdClass;
      $english_classes["memoir"]->name = "Memoir/Narrative/Fiction";
      $english_classes["memoir"]->levels[2] = "Middle School";
      $english_classes["memoir"]->levels[1] = "Elementary School";

      $english_classes["poetry"] = new stdClass;
      $english_classes["poetry"]->name = "Poetry";
      $english_classes["poetry"]->levels[2] = "Middle School";
      $english_classes["poetry"]->levels[1] = "Elementary School";

      $english_classes["english_project"] = new stdClass;
      $english_classes["english_project"]->name = "Project Help";
      $english_classes["english_project"]->levels[2] = "Middle School";
      $english_classes["english_project"]->levels[1] = "Elementary School";

      $english_classes["other_english"] = new stdClass;
      $english_classes["other_english"]->name = "Other (See About Me)";
      $english_classes["other_english"]->levels[2] = "Middle School";
      $english_classes["other_english"]->levels[1] = "Elementary School";


      //math
      $math_classes["elementary_math"] = new stdClass;
      $math_classes["elementary_math"]->name = "Elementary School Math";
      $math_classes["elementary_math"]->levels[3] = "Honors";
      $math_classes["elementary_math"]->levels[2] = "Standard";

      $math_classes["middle_math"] = new stdClass;
      $math_classes["middle_math"]->name = "Middle School Math";
      $math_classes["middle_math"]->levels[3] = "Honors";
      $math_classes["middle_math"]->levels[2] = "Standard";


      //science
      $science_classes["elementary_science"] = new stdClass;
      $science_classes["elementary_science"]->name = "Elementary School Science";
      $science_classes["elementary_science"]->levels[3] = "Honors";
      $science_classes["elementary_science"]->levels[2] = "Standard";

      $science_classes["middle_science"] = new stdClass;
      $science_classes["middle_science"]->name = "Middle School Science";
      $science_classes["middle_science"]->levels[3] = "Honors";
      $science_classes["middle_science"]->levels[2] = "Standard";


      //social studies
      $social_classes["elementary_social"] = new stdClass;
      $social_classes["elementary_social"]->name = "Elementary School Social Studies";
      $social_classes["elementary_social"]->levels[3] = "Honors";
      $social_classes["elementary_social"]->levels[2] = "Standard";

      $social_classes["middle_social"] = new stdClass;
      $social_classes["middle_social"]->name = "Middle School Social Studies";
      $social_classes["middle_social"]->levels[3] = "Honors";
      $social_classes["middle_social"]->levels[2] = "Standard";


      //foriegn language
      //french
      $french_classes["elementary_french"] = new stdClass;
      $french_classes["elementary_french"]->name = "Elementary School French";
      $french_classes["elementary_french"]->levels[3] = "Honors";
      $french_classes["elementary_french"]->levels[2] = "Standard";

      $french_classes["middle_french"] = new stdClass;
      $french_classes["middle_french"]->name = "Middle School French";
      $french_classes["middle_french"]->levels[3] = "Honors";
      $french_classes["middle_french"]->levels[2] = "Standard";


      //spanish
      $spanish_classes["elementary_spanish"] = new stdClass;
      $spanish_classes["elementary_spanish"]->name = "Elementary School Spanish";
      $spanish_classes["elementary_spanish"]->levels[3] = "Honors";
      $spanish_classes["elementary_spanish"]->levels[2] = "Level 1";

      $spanish_classes["middle_spanish"] = new stdClass;
      $spanish_classes["middle_spanish"]->name = "Middle School Spanish";
      $spanish_classes["middle_spanish"]->levels[3] = "Honors";
      $spanish_classes["middle_spanish"]->levels[2] = "Level 1";

      //do the insert
      foreach($subjects as $key=> $subject)
      {
        $model = MiddleSubject::create(['subject_name' => $subject]);
        foreach(${"{$key}_classes"} as $class_object)
        {
          $model->classes()->create(['class_name' => reset($class_object->levels).' '.$class_object->name]);
          $model->classes()->create(['class_name' => end($class_object->levels).' '.$class_object->name]);
        }
      }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      \DB::table('middle_classes')->delete();
      \DB::table('middle_subjects')->delete();
    }
}
