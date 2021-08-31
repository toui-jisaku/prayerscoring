<?php
session_start();
require_once(ROOT_PATH .'Controllers/UserController.php');
require_once(ROOT_PATH .'Controllers/PhotoController.php');
$user = new UserController();

$user->user_delete_complete();

header("Location:login.php");
?>

    <?php include dirname(__FILE__) . '/header1.php';?>
 