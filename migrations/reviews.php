<?php
//use this to migrate to new db
$servername = "localhost";
$username = $argv[1];
$password = $argv[2];
$old_name = $argv[3];
$new_name = $argv[4];

try {
    $old = new PDO("mysql:host=$servername;dbname=$old_name", $username, $password);
    $new = new PDO("mysql:host=$servername;dbname=$new_name", $username, $password);
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
    die();
}

$stmt = $old->prepare("SELECT * FROM reviews");
$stmt->execute();

$reviews = $stmt->fetchAll();

$user_fetch = $old->prepare("SELECT * FROM users where user_id = ?");

echo "Staring migration on reviews\n";
foreach ($reviews as $r)
{
  $old_reviewer = $r->reviewer_id;
  $old_tutor = $r->tutor_id;

  //get the row for the reviewer
  $user_fetch->execute([$old_reviewer]);
  $reviewer = $user_fetch->fetch();

  //get the row for the tutor
  $user_fetch->execute([$old_tutor]);
  $tutor = $user_fetch->fetch();

  //insert review into new db
  $insert = $new->prepare("INSERT INTO reviews (reviewer_id, tutor_id, rating, title, message, anonymous, reviewer, created_at, updated_at)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

  $insert->execute([get_new_id_by_email($reviewer->user_email, $new), get_new_id_by_email($tutor->user_email, $new), $r->rating, $r->review_title,
    $r->message, $r->anonymous, ucfirst($r->reviewer), date("Y-m-d H:i:s", $r->time), date("Y-m-d H:i:s", $r->time)]);
    echo "Migrated review '{$r->review_title} ($r->review_number)'\n";

}
echo "Finished migration of reviews \n\n";

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
