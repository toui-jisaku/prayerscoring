<?php
session_start();
require_once(ROOT_PATH .'Controllers/UserController.php');
require_once(ROOT_PATH .'Controllers/PhotoController.php');
$user = new UserController();
$photo =new PhotoController();

$photo->photo_edit_confirm();
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
  <title>投稿編集確認ページ</title>
  <link rel="stylesheet" type="text/css" href="/style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body>
  <header>
    <?php include dirname(__FILE__) . '/header1.php';?>
  </header>
  <section>
    <div class="main confirm_edit">
        <p><?php echo htmlspecialchars($login_user['name'],ENT_QUOTES,"UTF-8"); ?>さんの編集</p>
        <div class="view_image">
          <img src="<?php echo "/"."{$_SESSION['file_path']}"; ?>" alt="" width="300px" height="200px">
        </div>
        <div>
            <h2>ジャンル</h2>
            <p><?php echo ($_SESSION['genre']); ?></p>
        </div>
        <div>
            <h2>コメント</h2>
            <p><?php echo nl2br($_SESSION['comment'])?></p>
        </div>
        <div class="other other1">
                <div class="good">
                  <button type="button" onclick=history.back()>戻る</button>
                </div>
                <div class="post_date">
                  <a href="photo_complete_edit.php">登録</a>
                </div>
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