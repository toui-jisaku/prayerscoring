<?php
session_start();

require_once(ROOT_PATH .'Controllers/UserController.php');
require_once(ROOT_PATH .'Controllers/PhotoController.php');

$user = new UserController();
$photo =new PhotoController();
if(isset($_SESSION['errmessage'])){
  $errmessage = $_SESSION['errmessage'];
  unset($_SESSION['errmessage']);
}

$result = $user->checkLogin();

if (!$result) {
    $_SESSION['login_err'] = 'ユーザを登録してログインしてください';
    header('Location: signup.php');
    return;
}

$login_user = $_SESSION['login_user'];
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>アカウント編集</title>
  <link rel="stylesheet" type="text/css" href="/style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body>
  <header>
    <?php include dirname(__FILE__) . '/header1.php';?>
  </header>
  <section >
    <div class="main">
        <p>アカウント編集</p>
        <div class="err">
          <p>
              <?php if(isset($errmessage)): ?>
              <?php foreach($errmessage as $err): ?>
                  <?php echo $err. "</br>"; ?>
              <?php endforeach; ?>
              <?php endif; ?>
          </p>
        </div>
        <form action="user_edit_confirm.php" class="logform" method="post">
          <div>
              <label>ユーザーネーム：<label>
              <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($login_user['name'],ENT_QUOTES,"UTF-8"); ?>" style="width:300px;">
          </div>
          <div>
              <label>メールアドレス：<label>
              <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($login_user['email'],ENT_QUOTES,"UTF-8"); ?>" style="width:300px;">
          </div>
          <div>
              <label>パスワード：<label>
              <input type="password" name="password" value="" style="width:300px;">
          </div>
          <div>
              <label>パスワード確認：<label>
              <input type="password" name="password_conf" class="form" value="" style="width:300px;">
          </div>
          <div>
              <button type="submit" id="submit_btn">確認</button>
          </div>
        </form>
        <?php if($login_user['role'] == 0):?>
        <div>
          <a href="user_delete_confirm.php">アカウントを削除する</a>,本当に？？？
        </div>
        <?php endif; ?>
    </div>
    
  </section>
  <footer>
    <div class="footer_photo">
      <p>三浦知良の現在の年齢54歳</p>
    </div>
    
  </footer>
</body>
</html>