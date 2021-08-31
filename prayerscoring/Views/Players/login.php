<?php
session_start();
require_once(ROOT_PATH .'Controllers/UserController.php');
$user = new UserController();
if(isset($_SESSION['errmessage'])){
    $errmessage = $_SESSION['errmessage'];
    unset($_SESSION['errmessage']);
}

$result = $user->checkLogin();
if($result){
    header('Location: main.php');
    return;
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>prayerscoring　ログイン画面</title>
  <link rel="stylesheet" type="text/css" href="/style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body>
  <header>
    <?php include dirname(__FILE__) . '/header.php';?>
  </header>
  <section>
    <div class="login_image">
      <p>サッカーしたいなー♡</p>
    </div>
    <div class="err">
      <p>
          <?php if(isset($errmessage)): ?>
          <?php foreach($errmessage as $err): ?>
              <?php echo $err. "</br>"; ?>
          <?php endforeach; ?>
          <?php endif; ?>
      </p>
    </div>
    <div class="login_form">
      <form action="top.php" class="logform" method="post">
        <dl>
          <dt><label for="email">メールアドレス</label></dt>
          <dd><input type="email" name="email" id="email" class="form" value="" style="width:300px;"></dd>
          <dt><label for="password">パスワード<label></dt>
          <dd><input type="password" name="password" class="form" value="" style="width:300px;"></dd>
        </dl>
        <button type="submit" id="submit_btn">ログイン</button>
      </form>
      <div class="signuplink">
        <a href="signup.php">新規アカウント作成</a>
      </div>
      <div class="notlogin">
        <a href="post_index_not_login.php">ログインせずに使用</a>
      </div>

    </div>
  </section>
  <footer>
    <div class="footer_photo">
      <p>好きな選手の写真を共有しよう</p>
    </div>
    
  </footer>
</body>
</html>