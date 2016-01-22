<?php
include_once './vendor/autoload.php';
// import the Intervention Image Manager Class
use Intervention\Image\ImageManagerStatic as Image;

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

echo "Starting migration of pictures\n";

$old_dir = './pics/';
$directory = '../storage/app/images/';

$default = '../public/img/';

copy($default.'default.jpg', $directory.'default.jpg');
copy($default.'default_thumb.jpg', $directory.'default_thumb.jpg');

//under development
$fetch = $old->prepare("SELECT * from users WHERE user_has_avatar='1'");
$fetch->execute();

$results = $fetch->fetchAll();

//create two copies at different resolutions
foreach ($results as $res)
{
  $id = get_new_id_by_email($res->user_email, $new);

  if (file_exists($old_dir.$res->user_id.'.jpg'))
  {
    //open old image
    $image = Image::make($old_dir.$res->user_id.'.jpg');

    //make new directory
    mkdir($directory.$id, 0775);

    //save original
    $image->save($directory.$id.'/profile_original.jpg');
    $image->resize(720, 720)->save($directory.$id.'/profile_full.png');
    $image->resize(100, 100)->save($directory.$id.'/profile_thumb.jpg');
    echo ("Migrated profile picture for {$res->fname} {$res->lname} ({$res->user_id}->{$id})\n");
  }
  else
  {
    //list them as not having an image
    $rmv = $new->prepare("UPDATE users SET has_picture = 0 WHERE id = ?");
    $rmv->execute([$id]);
    echo ("Unable to find profile picture for {$res->fname} {$res->lname} ({$res->user_id}->{$id}), removing has_picture from db.\n");
  }


}

$count = count($results);
echo "Finished migration of {$count} pictures\n";


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
?>
