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

$login_err = isset($_SESSION['login_err']) ? $_SESSION['login_err'] : null;
unset($_SESSION['login_err']);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>prayerscoring　新規アカウント作成</title>
  <link rel="stylesheet" type="text/css" href="/style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body>
  <header>
    <?php include dirname(__FILE__) . '/header.php';?>
  </header>
  <section>
    <!-- <div class="login_image">
      <img src="/img/dog-cat-2479948__480.jpeg" width="300px" height="200px" alt="犬猫">
    </div> -->
    <div class="err">
      <?php if (isset($login_err)) :?>
          <p><?php echo $login_err; ?></p>
      <?php endif; ?>

      <p>
          <?php if(isset($errmessage)): ?>
          <?php foreach($errmessage as $err): ?>
              <?php echo $err. "</br>"; ?>
          <?php endforeach; ?>
          <?php endif; ?>
      </p>
    </div>
    <div class="login_form">
      <form action="register.php" class="logform" method="post">
        <dl>
          <dt><label for="name">ユーザーネーム</label></dt>
          <dd><input type="text" name="name" id="name" value="" style="width:300px;"></dd>
          <dt><label for="email">メールアドレス</label></dt>
          <dd><input type="email" name="email" id="email" value="" style="width:300px;"></dd>
          <dt><label for="password">パスワード<label></dt>
          <dd><input type="password" name="password" value="" style="width:300px;"></dd>
          <dt><label for="password">パスワード確認<label></dt>
          <dd><input type="password" name="password_conf" class="form" value="" style="width:300px;"></dd>
        </dl>
        <button type="submit" id="submit_btn">登録</button>
      </form>

    </div>
  </section>
  <footer>
    <div class="footer_photo">
      <p>ジーコの現在の年齢68歳</p>
    </div>
    
  </footer>
</body>
</html>