<?php
//use this to migrate to new db

$servername = "localhost";
$username = "homestead";
$password = "secret";

try {
    $old = new PDO("mysql:host=$servername;dbname=login", $username, $password);
    $new = new PDO("mysql:host=$servername;dbname=homestead", $username, $password);
    // set the PDO error mode to exception
    $old->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $new->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $old->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    $new->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    echo "Connected successfully\n";
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}


$subjects = array('math' => 'Math', 'english' => 'English', 'science' => 'Science', 'social' => 'Social Studies', 'french' => 'French', 'spanish' => 'Spanish', 'german' => 'German', 'italian' => 'Italian', 'mandarin' => 'Mandarin');

/* HIGH SCHOOL AND ABOVE CLASSES*/
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

/* MIDDLE AND BELOW CLASSES*/
$subjects2 = array('math' => 'Math', 'english' => 'English', 'science' => 'Science', 'social' => 'Social Studies', 'french' => 'French', 'spanish' => 'Spanish');
$english_classes2["analytical_essay"] = new stdClass;
$english_classes2["analytical_essay"]->name = "Analytical Essays";
$english_classes2["analytical_essay"]->levels[2] = "Middle School";
$english_classes2["analytical_essay"]->levels[1] = "Elementary School";
$english_classes2["memoir"] = new stdClass;
$english_classes2["memoir"]->name = "Memoir/Narrative/Fiction";
$english_classes2["memoir"]->levels[2] = "Middle School";
$english_classes2["memoir"]->levels[1] = "Elementary School";
$english_classes2["poetry"] = new stdClass;
$english_classes2["poetry"]->name = "Poetry";
$english_classes2["poetry"]->levels[2] = "Middle School";
$english_classes2["poetry"]->levels[1] = "Elementary School";
$english_classes2["english_project"] = new stdClass;
$english_classes2["english_project"]->name = "Project Help";
$english_classes2["english_project"]->levels[2] = "Middle School";
$english_classes2["english_project"]->levels[1] = "Elementary School";
$english_classes2["other_english"] = new stdClass;
$english_classes2["other_english"]->name = "Other (See About Me)";
$english_classes2["other_english"]->levels[2] = "Middle School";
$english_classes2["other_english"]->levels[1] = "Elementary School";
//math
$math_classes2["elementary_math"] = new stdClass;
$math_classes2["elementary_math"]->name = "Elementary School Math";
$math_classes2["elementary_math"]->levels[3] = "Honors";
$math_classes2["elementary_math"]->levels[2] = "Standard";
$math_classes2["middle_math"] = new stdClass;
$math_classes2["middle_math"]->name = "Middle School Math";
$math_classes2["middle_math"]->levels[3] = "Honors";
$math_classes2["middle_math"]->levels[2] = "Standard";
//science
$science_classes2["elementary_science"] = new stdClass;
$science_classes2["elementary_science"]->name = "Elementary School Science";
$science_classes2["elementary_science"]->levels[3] = "Honors";
$science_classes2["elementary_science"]->levels[2] = "Standard";
$science_classes2["middle_science"] = new stdClass;
$science_classes2["middle_science"]->name = "Middle School Science";
$science_classes2["middle_science"]->levels[3] = "Honors";
$science_classes2["middle_science"]->levels[2] = "Standard";
//social studies
$social_classes2["elementary_social"] = new stdClass;
$social_classes2["elementary_social"]->name = "Elementary School Social Studies";
$social_classes2["elementary_social"]->levels[3] = "Honors";
$social_classes2["elementary_social"]->levels[2] = "Standard";
$social_classes2["middle_social"] = new stdClass;
$social_classes2["middle_social"]->name = "Middle School Social Studies";
$social_classes2["middle_social"]->levels[3] = "Honors";
$social_classes2["middle_social"]->levels[2] = "Standard";
//foriegn language
//french
$french_classes2["elementary_french"] = new stdClass;
$french_classes2["elementary_french"]->name = "Elementary School French";
$french_classes2["elementary_french"]->levels[3] = "Honors";
$french_classes2["elementary_french"]->levels[2] = "Standard";
$french_classes2["middle_french"] = new stdClass;
$french_classes2["middle_french"]->name = "Middle School French";
$french_classes2["middle_french"]->levels[3] = "Honors";
$french_classes2["middle_french"]->levels[2] = "Standard";
//spanish
$spanish_classes2["elementary_spanish"] = new stdClass;
$spanish_classes2["elementary_spanish"]->name = "Elementary School Spanish";
$spanish_classes2["elementary_spanish"]->levels[3] = "Honors";
$spanish_classes2["elementary_spanish"]->levels[2] = "Level 1";
$spanish_classes2["middle_spanish"] = new stdClass;
$spanish_classes2["middle_spanish"]->name = "Middle School Spanish";
$spanish_classes2["middle_spanish"]->levels[3] = "Honors";
$spanish_classes2["middle_spanish"]->levels[2] = "Level 1";
//do the insert


//connection established
echo "Loading all users from DB\n";
$select = $old->prepare('SELECT * FROM users LEFT JOIN tutors ON users.user_id = tutors.id');
$select->execute();
$users = $select->fetchAll();
echo "User's loaded\n";
//inserts into new framework
$insert = $new->prepare("INSERT into users (fname, lname, password, account_type, email, lat, lon,
    user_active, zip_id, has_picture, last_login, created_at, updated_at)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$tutor_insert = $new->prepare("INSERT into tutors (user_id, tutor_active, profile_expiration,
    profile_views, contact_num, age, grade, rate, about_me, created_at, updated_at)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$zip_query = $new->prepare("SELECT * FROM zips WHERE zip_code = 02421");
$zip_query->execute();
$zip_res = $zip_query->fetch();
$lex_zip = $zip_res->id;

    //migrate user/tutor info
    foreach ($users as $u)
    {
        //insert user data
        $insert->execute([$u->fname, $u->lname, $u->user_password_hash, $u->user_account_type,
            $u->user_email, $zip_res->lat, $zip_res->lon, $u->user_active, $lex_zip, $u->user_has_avatar,
            date("Y-m-d H:i:s", $u->user_last_login_timestamp), date("Y-m-d H:i:s", $u->user_creation_timestamp),
            date("Y-m-d H:i:s", $u->user_last_login_timestamp)]);

        $new_id = $new->lastInsertId();

        echo "Migrated user {$u->fname} {$u->lname} ({$u->user_id}->{$new_id})\n";
        //if tutor, insert tutor specific info
        if ($u->user_account_type >= 2)
        {
            //migrate tutor info
            $tutor_insert->execute([$new_id, $u->tutor_active, date("Y-m-d H:i:s", $u->profile_expiration),
                $u->profile_views, $u->contact_num, $u->age, $u->grade, $u->rate, $u->about_me,
                date("Y-m-d H:i:s"), date("Y-m-d H:i:s")]);

            //add LHS
            $school_insert = $new->prepare("INSERT INTO tutor_schools (tutor_id, school_id,
              created_at, updated_at) VALUES (?, ?, ?, ?)");

            //assume LHS is id 1
            $school_insert->execute([$new_id, 1, date("Y-m-d H:i:s", $u->user_last_login_timestamp),
              date("Y-m-d H:i:s", $u->user_last_login_timestamp)]);

            echo "Migrated tutor {$u->fname} {$u->lname} ({$u->user_id}->{$new_id})\n";

            //migrate tutor classes info
            $num_classes = 0;
            foreach ($subjects as $prefix => $sub_name)
            {
                //get the subject model for the school
                foreach (${$prefix.'_classes'} as $class_key => $class)
                {
                    //check if the tutor tutors this class
                    if ($u->{$class_key})
                    {
                        //find the the class_id
                        $class_search = $new->prepare("SELECT levels.id FROM classes INNER JOIN
                            levels ON classes.id = levels.class_id WHERE
                            class_name = ? AND level_name = ?");

                        echo "Looking for {$class->name}, level_num: {$u->{$class_key}}\n";


                        if(array_key_exists($u->{$class_key}, $class->levels))
                        {
                          $class_search->execute([$class->name, $class->levels[$u->{$class_key}]]);
                          $level_object = $class_search->fetch();
                          if (empty($level_object))
                          {
                              //make sure we found the lookup
                              echo "Unable to find id for '{$class->name} ({$class->levels[$u->{$class_key}]})' \n";
                          }
                          else {
                              $level_id = $level_object->id;
                              $t_lev = $new->prepare("INSERT INTO tutor_levels
                                  (user_id, level_id, created_at, updated_at) VALUES (?, ?, ?, ?)");
                              $t_lev->execute([$new_id, $level_id, date("Y-m-d H:i:s", $u->user_last_login_timestamp),
                                  date("Y-m-d H:i:s", $u->user_last_login_timestamp)]);
                              $num_classes++;
                          }
                        }

                        else {
                          echo "Unable to find corresponding class for: {$class->name} (level: {$u->{$class_key}})\n";
                        }

                    }
                }
            }
            echo "Migrated {$num_classes} high school+ classes for {$u->fname} {$u->lname} ({$u->user_id}->{$new_id})\n";
            //migrate music classes
            $middle_classes = 0;
            foreach($subjects2 as $prefix => $sub_name)
            {
                foreach(${"{$prefix}_classes2"} as $class_key => $class)
                {
                    if ($u->{$class_key})
                    {
                        //find the the class_id
                        $class_search = $new->prepare("SELECT id FROM middle_classes
                            WHERE class_name = ?");

                        echo "Looking for {$class->name}, level_num: {$u->{$class_key}}\n";
                        if(array_key_exists($u->{$class_key}, $class->levels))
                        {
                          $class_search->execute([$class->levels[$u->{$class_key}].' '.$class->name]);
                          $level_object = $class_search->fetch();
                          if (empty($level_object))
                          {
                              //make sure we found the lookup
                              echo "Unable to find id for '{$class->name} ({$class->levels[$u->{$class_key}]})' \n";
                          }
                          else {
                              $class_id = $level_object->id;
                              $t_mclass = $new->prepare("INSERT INTO tutor_middle_classes
                                  (tutor_id, middle_classes_id, created_at, updated_at) VALUES (?, ?, ?, ?)");
                              $t_mclass->execute([$new_id, $class_id, date("Y-m-d H:i:s", $u->user_last_login_timestamp),
                                  date("Y-m-d H:i:s", $u->user_last_login_timestamp)]);
                              $middle_classes++;
                          }
                        }

                        else {
                          echo "Unable to find corresponding class for: {$class->name} (level: {$u->{$class_key}})\n";
                        }
                    }
                }
            }
            echo "Migrated {$middle_classes} middle classes for {$u->fname} {$u->lname} ({$u->user_id}->{$new_id})\n";

            //migrate any instruments

            //convert music level into upto years
            $music_level[1] = 0;
            $music_level[2] = 3;
            $music_level[3] = 6;
            $music_level[4] = 10;

            if (!empty($u->instrument))
            {
                $inst_search = $new->prepare("SELECT id FROM music WHERE music_name = ?");
                $inst_search->execute([$u->instrument]);
                $music_object = $inst_search->fetch();

                if (empty($music_object))
                {
                    echo "Unable to find id for instrument: '{$u->instrument}'.";
                }
                else {

                    $music_insert = $new->prepare("INSERT INTO tutor_music (tutor_id,
                        music_id, years_experiance, upto_years, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)");
                    $music_insert->execute([$new_id, $music_object->id, $u->music_years, $music_level[$u->music_level],
                        date("Y-m-d H:i:s", $u->user_last_login_timestamp), date("Y-m-d H:i:s", $u->user_last_login_timestamp)]);
                }
                print "Finished migrating '{$u->instrument}' for {$u->fname} {$u->lname}\n\n";
            }


        } //end tutor migration
        print "Finished migrating user: {$u->fname} {$u->lname} ({$u->user_id}->{$new_id})\n\n";
    } //end user migration

?>
