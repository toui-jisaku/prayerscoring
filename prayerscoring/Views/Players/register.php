<?php
session_start();
require_once(ROOT_PATH .'Controllers/UserController.php');
$user = new UserController();
$errmessage = $user->validate_register();

if(count($errmessage) !== 0) {
    $_SESSION['errmessage'] = $errmessage;
    $_SESSION['user']['email'] = $_POST['email'];
    $_SESSION['user']['password'] = $_POST['password'];
    $_SESSION['user']['password_conf'] = $_POST['password_conf'];
    header("Location:signup.php");
} else {
    $post = $user->register();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ユーザー登録完了</title>
  <link rel="stylesheet" type="text/css" href="/style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body>
  <header>
    <?php include dirname(__FILE__) . '/header.php';?>
  </header>
  <section>
    <div class="main">
        <p>登録完了</p>
        <a href="login.php">ログイン画面へ</a>
    </div>
    
  </section>
  <footer>
    <div class="footer_photo">
      <p>ごちそうさまです</p>
    </div>
    
  </footer>
</body>
</html>