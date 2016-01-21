<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Models\School\School;
use App\Models\Zip\Zip;

class InsertClasses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

//create LHs listing
$school = new School;
$school->school_name = 'Lexington High School';
$school->address = '251 Waltham Street, Lexington, MA 02421';
$school->lat = 42.443154;
$school->lon = -71.232905;
$school= Zip::where('city', '=', 'LEXINGTON')->where('zip_code', '=', '02421')
->first()
->schools()
->save($school);

$subjects = array('math' => 'Math', 'english' => 'English', 'science' => 'Science', 'social' => 'Social Studies', 'french' => 'French', 'spanish' => 'Spanish', 'german' => 'German', 'italian' => 'Italian', 'mandarin' => 'Mandarin');

foreach($subjects as $subject)
{
  $school->subjects()->create(['subject_name' => $subject]);
}
//english
$english_classes["analytical_essay"] = new stdClass;
$english_classes["analytical_essay"]->name = "Analytical Essays";
$english_classes["analytical_essay"]->levels[4] = "High School (11-12th)";
$english_classes["analytical_essay"]->levels[3] = "High School (9-10th)";

$english_classes["memoir"] = new stdClass;
$english_classes["memoir"]->name = "Memoir/Narrative/Fiction";
$english_classes["memoir"]->levels[4] = "High School (11-12th)";
$english_classes["memoir"]->levels[3] = "High School (9-10th)";
$english_classes["memoir"]->levels[2] = "Middle School";
$english_classes["memoir"]->levels[1] = "Elementary School";

$english_classes["poetry"] = new stdClass;
$english_classes["poetry"]->name = "Poetry";
$english_classes["poetry"]->levels[4] = "High School (11-12th)";
$english_classes["poetry"]->levels[3] = "High School (9-10th)";
$english_classes["poetry"]->levels[2] = "Middle School";
$english_classes["poetry"]->levels[1] = "Elementary School";

$english_classes["english_project"] = new stdClass;
$english_classes["english_project"]->name = "Project Help";
$english_classes["english_project"]->levels[4] = "High School (11-12th)";
$english_classes["english_project"]->levels[3] = "High School (9-10th)";
$english_classes["english_project"]->levels[2] = "Middle School";
$english_classes["english_project"]->levels[1] = "Elementary School";

$english_classes["other_english"] = new stdClass;
$english_classes["other_english"]->name = "Other (See About Me)";
$english_classes["other_english"]->levels[4] = "High School (11-12th)";
$english_classes["other_english"]->levels[3] = "High School (9-10th)";
$english_classes["other_english"]->levels[2] = "Middle School";
$english_classes["other_english"]->levels[1] = "Elementary School";


//math
$math_classes["math_1"] = new stdClass;
$math_classes["math_1"]->name = "Math 1";
$math_classes["math_1"]->levels[3] = "Honors";
$math_classes["math_1"]->levels[2] = "Level 1";
$math_classes["math_1"]->levels[1] = "Level 2";
$math_classes["math_2"] = new stdClass;
$math_classes["math_2"]->name = "Math 2";
$math_classes["math_2"]->levels[3] = "Honors";
$math_classes["math_2"]->levels[2] = "Level 1";
$math_classes["math_2"]->levels[1] = "Level 2";

$math_classes["math_3"] = new stdClass;
$math_classes["math_3"]->name = "Math 3";
$math_classes["math_3"]->levels[3] = "Honors";
$math_classes["math_3"]->levels[2] = "Level 1";
$math_classes["math_3"]->levels[1] = "Level 2";

$math_classes["math_4"] = new stdClass;
$math_classes["math_4"]->name = "Math 4";
$math_classes["math_4"]->levels[3] = "Honors";
$math_classes["math_4"]->levels[2] = "Level 1";
$math_classes["math_4"]->levels[1] = "Level 2";

$math_classes["stats"] = new stdClass;
$math_classes["stats"]->name = "Statistics";
$math_classes["stats"]->levels[4] = "AP";
$math_classes["stats"]->levels[3] = "Honors";
$math_classes["stats"]->levels[2] = "Level 1";
$math_classes["stats"]->levels[1] = "Level 2";

$math_classes["comp_sci"] = new stdClass;
$math_classes["comp_sci"]->name = "Computer Science";
$math_classes["comp_sci"]->levels[4] = "AP";


$math_classes["calc"] = new stdClass;
$math_classes["calc"]->name = "Calculus";
$math_classes["calc"]->levels[5] = "AP BC";
$math_classes["calc"]->levels[4] = "AP AB";
$math_classes["calc"]->levels[3] = "Honors";
$math_classes["calc"]->levels[2] = "Level 1";
$math_classes["calc"]->levels[1] = "Level 2";


//science
$science_classes["earth_science"] = new stdClass;
$science_classes["earth_science"]->name = "Earth Science";
$science_classes["earth_science"]->levels[3] = "Honors";
$science_classes["earth_science"]->levels[2] = "Level 1";
$science_classes["earth_science"]->levels[1] = "Level 2";

$science_classes["bio"] = new stdClass;
$science_classes["bio"]->name = "Biology";
$science_classes["bio"]->levels[4] = "AP";
$science_classes["bio"]->levels[3] = "Honors";
$science_classes["bio"]->levels[2] = "Level 1";
$science_classes["bio"]->levels[1] = "Level 2";

$science_classes["chem"] = new stdClass;
$science_classes["chem"]->name = "Chemistry";
$science_classes["chem"]->levels[4] = "AP";
$science_classes["chem"]->levels[3] = "Honors";
$science_classes["chem"]->levels[2] = "Level 1";
$science_classes["chem"]->levels[1] = "Level 2";
$science_classes["phys"] = new stdClass;

$science_classes["phys"]->name = "Physics";
$science_classes["phys"]->levels[5] = "AP C";
$science_classes["phys"]->levels[4] = "AP I";
$science_classes["phys"]->levels[3] = "Honors";
$science_classes["phys"]->levels[2] = "Level 1";
$science_classes["phys"]->levels[1] = "Level 2";


//social studies
$social_classes["world_history_1"] = new stdClass;
$social_classes["world_history_1"]->name = "World History 1";
$social_classes["world_history_1"]->levels[3] = "Honors";
$social_classes["world_history_1"]->levels[2] = "Level 1";
$social_classes["world_history_1"]->levels[1] = "Level 2";

$social_classes["world_history_2"] = new stdClass;
$social_classes["world_history_2"]->name = "World History 2";
$social_classes["world_history_2"]->levels[3] = "Honors";
$social_classes["world_history_2"]->levels[2] = "Level 1";
$social_classes["world_history_2"]->levels[1] = "Level 2";

$social_classes["ap_world"] = new stdClass;
$social_classes["ap_world"]->name = "AP World History";
$social_classes["ap_world"]->levels[4] = "AP";

$social_classes["us_history"] = new stdClass;
$social_classes["us_history"]->name = "US History";
$social_classes["us_history"]->levels[4] = "AP";
$social_classes["us_history"]->levels[2] = "Level 1";
$social_classes["us_history"]->levels[1] = "Level 2";

$social_classes["econ"] = new stdClass;
$social_classes["econ"]->name = "Economics";
$social_classes["econ"]->levels[4] = "AP";
$social_classes["econ"]->levels[3] = "Honors";
$social_classes["econ"]->levels[2] = "Level 1";
$social_classes["econ"]->levels[1] = "Level 2";

$social_classes["psych"] = new stdClass;
$social_classes["psych"]->name = "Psychology";
$social_classes["psych"]->levels[4] = "AP";
$social_classes["psych"]->levels[3] = "Honors";
$social_classes["psych"]->levels[2] = "Level 1";
$social_classes["psych"]->levels[1] = "Level 2";


//foriegn language
//french
$french_classes["french_1"] = new stdClass;
$french_classes["french_1"]->name = "French 1";
$french_classes["french_1"]->levels[3] = "Honors";
$french_classes["french_1"]->levels[2] = "Level 1";
$french_classes["french_1"]->levels[1] = "Level 2";

$french_classes["french_2"] = new stdClass;
$french_classes["french_2"]->name = "French 2";
$french_classes["french_2"]->levels[3] = "Honors";
$french_classes["french_2"]->levels[2] = "Level 1";
$french_classes["french_2"]->levels[1] = "Level 2";

$french_classes["french_3"] = new stdClass;
$french_classes["french_3"]->name = "French 3";
$french_classes["french_3"]->levels[3] = "Honors";
$french_classes["french_3"]->levels[2] = "Level 1";
$french_classes["french_3"]->levels[1] = "Level 2";

$french_classes["french_4"] = new stdClass;
$french_classes["french_4"]->name = "French 4";
$french_classes["french_4"]->levels[3] = "Honors";
$french_classes["french_4"]->levels[2] = "Level 1";
$french_classes["french_4"]->levels[1] = "Level 2";

$french_classes["french_5"] = new stdClass;
$french_classes["french_5"]->name = "French 5";
$french_classes["french_5"]->levels[3] = "Honors";
$french_classes["french_5"]->levels[2] = "Level 1";
$french_classes["french_5"]->levels[1] = "Level 2";

$french_classes["french_AP"] = new stdClass;
$french_classes["french_AP"]->name = "AP French";
$french_classes["french_AP"]->levels[4] = "AP";

//spanish
$spanish_classes["spanish_1"] = new stdClass;
$spanish_classes["spanish_1"]->name = "Spanish 1";
$spanish_classes["spanish_1"]->levels[3] = "Honors";
$spanish_classes["spanish_1"]->levels[2] = "Level 1";
$spanish_classes["spanish_1"]->levels[1] = "Level 2";

$spanish_classes["spanish_2"] = new stdClass;
$spanish_classes["spanish_2"]->name = "Spanish 2";
$spanish_classes["spanish_2"]->levels[3] = "Honors";
$spanish_classes["spanish_2"]->levels[2] = "Level 1";
$spanish_classes["spanish_2"]->levels[1] = "Level 2";

$spanish_classes["spanish_3"] = new stdClass;
$spanish_classes["spanish_3"]->name = "Spanish 3";
$spanish_classes["spanish_3"]->levels[3] = "Honors";
$spanish_classes["spanish_3"]->levels[2] = "Level 1";
$spanish_classes["spanish_3"]->levels[1] = "Level 2";

$spanish_classes["spanish_4"] = new stdClass;
$spanish_classes["spanish_4"]->name = "Spanish 4";
$spanish_classes["spanish_4"]->levels[3] = "Honors";
$spanish_classes["spanish_4"]->levels[2] = "Level 1";
$spanish_classes["spanish_4"]->levels[1] = "Level 2";

$spanish_classes["spanish_5"] = new stdClass;
$spanish_classes["spanish_5"]->name = "Spanish 5";
$spanish_classes["spanish_5"]->levels[3] = "Honors";
$spanish_classes["spanish_5"]->levels[2] = "Level 1";
$spanish_classes["spanish_5"]->levels[1] = "Level 2";

$spanish_classes["spanish_AP"] = new stdClass;
$spanish_classes["spanish_AP"]->name = "AP Spanish";
$spanish_classes["spanish_AP"]->levels[4] = "AP";

//german
$german_classes["german_1"] = new stdClass;
$german_classes["german_1"]->name = "German 1";
$german_classes["german_1"]->levels[3] = "Honors";
$german_classes["german_1"]->levels[2] = "Level 1";
$german_classes["german_1"]->levels[1] = "Level 2";

$german_classes["german_2"] = new stdClass;
$german_classes["german_2"]->name = "German 2";
$german_classes["german_2"]->levels[3] = "Honors";
$german_classes["german_2"]->levels[2] = "Level 1";
$german_classes["german_2"]->levels[1] = "Level 2";

$german_classes["german_3"] = new stdClass;
$german_classes["german_3"]->name = "German 3";
$german_classes["german_3"]->levels[3] = "Honors";
$german_classes["german_3"]->levels[2] = "Level 1";
$german_classes["german_3"]->levels[1] = "Level 2";

$german_classes["german_4"] = new stdClass;
$german_classes["german_4"]->name = "German 4";
$german_classes["german_4"]->levels[3] = "Honors";
$german_classes["german_4"]->levels[2] = "Level 1";
$german_classes["german_4"]->levels[1] = "Level 2";

//italian
$italian_classes["italian_1"] = new stdClass;
$italian_classes["italian_1"]->name = "Italian 1";
$italian_classes["italian_1"]->levels[3] = "Honors";
$italian_classes["italian_1"]->levels[2] = "Level 1";
$italian_classes["italian_1"]->levels[1] = "Level 2";

$italian_classes["italian_2"] = new stdClass;
$italian_classes["italian_2"]->name = "Italian 2";
$italian_classes["italian_2"]->levels[3] = "Honors";
$italian_classes["italian_2"]->levels[2] = "Level 1";
$italian_classes["italian_2"]->levels[1] = "Level 2";

$italian_classes["italian_3"] = new stdClass;
$italian_classes["italian_3"]->name = "Italian 3";
$italian_classes["italian_3"]->levels[3] = "Honors";
$italian_classes["italian_3"]->levels[2] = "Level 1";
$italian_classes["italian_3"]->levels[1] = "Level 2";

$italian_classes["italian_4"] = new stdClass;
$italian_classes["italian_4"]->name = "Italian 4";
$italian_classes["italian_4"]->levels[3] = "Honors";
$italian_classes["italian_4"]->levels[2] = "Level 1";
$italian_classes["italian_4"]->levels[1] = "Level 2";

$italian_classes["italian_AP"] = new stdClass;
$italian_classes["italian_AP"]->name = "AP Italian";
$italian_classes["italian_AP"]->levels[4] = "AP";


//mandarin
$mandarin_classes["mandarin_1"] = new stdClass;
$mandarin_classes["mandarin_1"]->name = "Mandarin 1";
$mandarin_classes["mandarin_1"]->levels[3] = "Honors";
$mandarin_classes["mandarin_1"]->levels[2] = "Level 1";
$mandarin_classes["mandarin_1"]->levels[1] = "Level 2";

$mandarin_classes["mandarin_2"] = new stdClass;
$mandarin_classes["mandarin_2"]->name = "Mandarin 2";
$mandarin_classes["mandarin_2"]->levels[3] = "Honors";
$mandarin_classes["mandarin_2"]->levels[2] = "Level 1";
$mandarin_classes["mandarin_2"]->levels[1] = "Level 2";

$mandarin_classes["mandarin_3"] = new stdClass;
$mandarin_classes["mandarin_3"]->name = "Mandarin 3";
$mandarin_classes["mandarin_3"]->levels[3] = "Honors";
$mandarin_classes["mandarin_3"]->levels[2] = "Level 1";
$mandarin_classes["mandarin_3"]->levels[1] = "Level 2";

$mandarin_classes["mandarin_4"] = new stdClass;
$mandarin_classes["mandarin_4"]->name = "Mandarin 4";
$mandarin_classes["mandarin_4"]->levels[3] = "Honors";
$mandarin_classes["mandarin_4"]->levels[2] = "Level 1";
$mandarin_classes["mandarin_4"]->levels[1] = "Level 2";

$mandarin_classes["mandarin_5"] = new stdClass;
$mandarin_classes["mandarin_5"]->name = "Mandarin 5";
$mandarin_classes["mandarin_5"]->levels[3] = "Honors";
$mandarin_classes["mandarin_5"]->levels[2] = "Level 1";
$mandarin_classes["mandarin_5"]->levels[1] = "Level 2";

$mandarin_classes["mandarin_AP"] = new stdClass;
$mandarin_classes["mandarin_AP"]->name = "AP Mandarin";
$mandarin_classes["mandarin_AP"]->levels[4] = "AP";




foreach ($subjects as $prefix => $sub_name)
{
  //get the subject model for the school
  $sub_model = $school->subjects()->where('subject_name', $sub_name)->firstOrFail();


  foreach (${$prefix.'_classes'} as $class)
  {
    $class_mod = $sub_model->classes()->create(['class_name' => $class->name]);

    foreach($class->levels as $level_num => $level_name)
    {
      $class_mod->levels()->create(['level_name' => $level_name, 'level_num' => $level_num]);
    }

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
        Schema::table('classes', function (Blueprint $table) {
            //
        });
    }
}
