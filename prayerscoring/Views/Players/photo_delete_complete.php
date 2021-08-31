<?php
session_start();
require_once(ROOT_PATH .'Controllers/UserController.php');
require_once(ROOT_PATH .'Controllers/PhotoController.php');
$user = new UserController();
$photo =new PhotoController();

$photo->delete_photo();
$result = $user->checkLogin();

if (!$result) {
    $_SESSION['login_err'] = 'ユーザを登録してログインしてください';
    header('Location: signup.php');
    return;
}
header("Location:main.php");
?>

    <?php include dirname(__FILE__) . '/header1.php';?>
