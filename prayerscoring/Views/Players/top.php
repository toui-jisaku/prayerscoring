<?php
session_start();
require_once(ROOT_PATH .'Controllers/UserController.php');
$user = new UserController();
$errmessage = $user->login();

if(count($errmessage) !== 0) {
    $_SESSION['errmessage'] = $errmessage;
    $_SESSION['user']['email'] = $_POST['email'];
    $_SESSION['user']['password'] = $_POST['password'];
    header("Location:login.php");
} else {
    $post = $user->login();
    header("Location:main.php");
}
?>

    <?php include dirname(__FILE__) . '/header1.php';?>
