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

$stmt = $old->prepare("SELECT * FROM users WHERE saved_tutors_id != ''");
$stmt->execute();

$users = $stmt->fetchAll();

$user_fetch = $old->prepare("SELECT * FROM users where user_id = ?");

$insert = $new->prepare("INSERT INTO saved_tutors (user_id, tutor_id, created_at, updated_at)
  VALUES (?, ?, ?, ?)");

echo "Staring migration of saved tutors\n";

foreach ($users as $u)
{
  $user_saved_tutors = getSavedTutors($u->user_id, $old);

  $new_uid = get_new_id_by_email($u->user_email, $new);

  foreach($user_saved_tutors as $t_id => $time)
  {
    //get the new id for the tutor
    $user_fetch->execute([$t_id]);
    $saved_tutor = $user_fetch->fetch();

    //insert the saved tutor
    $new_tid = get_new_id_by_email($saved_tutor->user_email, $new);

    $insert->execute([$new_uid, $new_tid,
      date("Y-m-d H:i:s", $time), date("Y-m-d H:i:s", $time)]);

    echo "Migrated saved tutor '{$saved_tutor->fname} {$saved_tutor->lname}' ({$saved_tutor->user_id}->{$new_tid}) for '{$u->fname} {$u->lname}' ({$u->user_id}->{$new_uid})\n";
  }

}
echo "Finished migration of saved_tutors \n\n";

function get_new_id_by_email($email, $db)
{
  $query = $db->prepare("SELECT id FROM users WHERE email = ?");
  $query->execute([$email]);

  $user = $query->fetch();

  if (empty($user))
  {
    print "Error finding user with email {$email}\n";
    die;
  }
  return $user->id;
}


function getSavedTutors($id, $old)
{
    $query = $old->prepare("SELECT saved_tutors_id, saved_tutors_time FROM users WHERE user_id = :user_id LIMIT 1");
    $query->execute(array(':user_id' => $id));
    $results = $query->fetch();
    $tutor_array = array();
    if (!empty($results->saved_tutors_id) && !empty($results->saved_tutors_time))
    {
        $saved_tutors_id = explode(",", $results->saved_tutors_id);
        $saved_tutors_time = explode(",", $results->saved_tutors_time);
        if (count($saved_tutors_id) == count($saved_tutors_time))
        {
            for($i=0; $i < count($saved_tutors_id); $i++) $tutor_array[$saved_tutors_id[$i]] = $saved_tutors_time[$i];
                //check if saved tutor has changed there account type, if so remove from array
                $stmt = $old->prepare("SELECT user_id, user_account_type FROM users WHERE user_id = :user_id");
            foreach ($tutor_array as $id => $time)
            {
                $stmt->execute(array(':user_id' => $id));
                $results = $stmt->fetch();
                if ($stmt->rowCount() != 1 || $results->user_account_type < 2) unset($tutor_array[$id]);
            }
        }
    }
    return $tutor_array;
}
