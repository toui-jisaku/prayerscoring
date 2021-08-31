<?php
header("Content-Type: application/json; charset=UTF-8");
session_start();
session_regenerate_id(true);
require_once(ROOT_PATH .'Controllers/UserController.php');
require_once(ROOT_PATH .'Controllers/PhotoController.php');
require_once(ROOT_PATH .'Controllers/GoodController.php');

$user = new UserController();
$photo =new PhotoController();
$good =new GoodController();


if(isset($_POST)){
    //既に登録されているか確認
    $user_id = $_POST['user_id'];
        $photo_id = $_POST['photo_id'];
    if($good->check_favolite_duplicate2()){
      $good->delete_good();
    }else{
      $good->insert_good();
    }
  
  }
  
?>

