<?php
session_start();

require_once(ROOT_PATH .'Controllers/UserController.php');
require_once(ROOT_PATH .'Controllers/PhotoController.php');

$user = new UserController();
$photo =new PhotoController();

$params = $photo->main_post();
$result = $user->checkLogin();

if (!$result) {
    $_SESSION['login_err'] = 'ユーザを登録してログインしてください';
    header('Location: signup.php');
    return;
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>管理者メインページ</title>
  <link rel="stylesheet" type="text/css" href="/style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body>
  <header>
    <?php include dirname(__FILE__) . '/header1.php';?>
  </header>
  <section>
    <div class="main">
        <p>アカウント情報</p>
        <p>管理者ページ</p>
        <div>
            <label>ユーザーネーム：<?php echo htmlspecialchars($login_user['name'],ENT_QUOTES,"UTF-8"); ?><label>
            
        </div>
        <div>
            <label>メールアドレス：<?php echo htmlspecialchars($login_user['email'],ENT_QUOTES,"UTF-8"); ?><label>
            
        </div>
        <div>
            <a href="user_edit.php">アカウント情報を編集する</a>
        </div>
        <div>
            <a href="user_index_manager.php">ユーザー一覧</a>
        </div>
        <div>
            <a href="post_index_manager.php">投稿一覧</a>
        </div>
    </div>
    
  </section>
  <footer>
    <div class="footer_photo">
      <p></p>
    </div>
    
  </footer>
</body>
</html>