<?php
session_start();
require_once(ROOT_PATH .'Controllers/UserController.php');
require_once(ROOT_PATH .'Controllers/PhotoController.php');
$user = new UserController();

$user->user_deleteBy_manager();

header("Location:user_index_manager.php");
?>