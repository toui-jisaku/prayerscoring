<?php
session_start();
require_once(ROOT_PATH .'Controllers/UserController.php');
$user = new UserController();
if(!$logout = filter_input(INPUT_POST, 'logout')){
    exit('不正なリクエストです。');
}
// ログインしているか判定し、セッションが切れていたらログインしてくださいとメッセージを出す。
$result = $user->checkLogin();
if (!$result) {
    exit('セッションが切れましたので、ログインし直してください。');
}
$user->logout();
header("Location:login.php");
?>

    <?php include dirname(__FILE__) . '/header.php';?>
