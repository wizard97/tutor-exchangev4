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

$stmt = $old->prepare("SELECT * FROM emails WHERE email_type = 'tutor_contact'");
$stmt->execute();

$contacts = $stmt->fetchAll();

$user_fetch = $old->prepare("SELECT * FROM users where user_id = ?");

echo "Staring migration of tutor contacts\n";
foreach ($contacts as $c)
{
  $old_contacter = $c->from_id;
  $old_tutor = $c->to_id;

  //get the row for the reviewer
  $user_fetch->execute([$old_contacter]);
  $contacter = $user_fetch->fetch();

  //get the row for the tutor
  $user_fetch->execute([$old_tutor]);
  $tutor = $user_fetch->fetch();

  //insert review into new db
  $createThread = $new->prepare("INSERT INTO threads (subject, created_at, updated_at)
    VALUES (?, ?, ?)");

  $addParticipant = $new->prepare("INSERT INTO participants (thread_id, user_id, last_read, created_at, updated_at)
    VALUES (?, ?, ?, ?, ?)");

  $newMessage = $new->prepare("INSERT INTO messages (thread_id, user_id, body, created_at, updated_at)
    VALUES (?, ?, ?, ?, ?)");

  $createThread->execute([$c->subject, date("Y-m-d H:i:s", $c->time_sent), date("Y-m-d H:i:s", $c->time_sent)]);
  echo "Created thread for '{$c->subject} ($c->message_num)'\n";

  $threadId = $new->lastInsertId();

  // Add both participants
  $addParticipant->execute([$threadId, get_new_id_by_email($contacter->user_email, $new),
      NULL, date("Y-m-d H:i:s", $c->time_sent), date("Y-m-d H:i:s", $c->time_sent)]);


  $addParticipant->execute([$threadId, get_new_id_by_email($tutor->user_email, $new),
      NULL, date("Y-m-d H:i:s", $c->time_sent), date("Y-m-d H:i:s", $c->time_sent)]);


    //remove everything before forwarded message
  $message_array = explode("Begin Forwarded Message_____", $c->message);

  if (array_key_exists(1, $message_array))
  {
    $message = ltrim($message_array[1]);
  }
  else $message = $c->message;

  $newMessage->execute([$threadId, get_new_id_by_email($contacter->user_email, $new),
      $message, date("Y-m-d H:i:s", $c->time_sent), date("Y-m-d H:i:s", $c->time_sent)]);

  echo "Migrated tutor message for '{$c->subject} ($c->message_num)'\n";

}
echo "Finished migration of tutor contacts \n\n";

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
