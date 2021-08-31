<?php
session_start();
require_once(ROOT_PATH .'Controllers/UserController.php');
require_once(ROOT_PATH .'Controllers/PhotoController.php');
$user = new UserController();
$photo =new PhotoController();

$errmessage = $photo->photo_postValidate();


if(count($errmessage) !== 0) {
    $_SESSION['errmessage'] = $errmessage;
    // $_SESSION['photo']['photo'] = $_POST['photo'];
    $_SESSION['photo']['genre'] = $_POST['genre'];
    $_SESSION['photo']['comment'] = $_POST['comment'];
    header("Location:post.php");
} else {
  $photo->photo_post_confirm();
}

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
  <title>投稿確認ページ</title>
  <link rel="stylesheet" type="text/css" href="/style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body>
  <header>
    <?php include dirname(__FILE__) . '/header1.php';?>
  </header>
  <section>
    <div class="main confirm_edit">
        <p><?php echo htmlspecialchars($login_user['name'],ENT_QUOTES,"UTF-8"); ?>さんの投稿</p>
        <form action="post_complete.php" method="post">
          <div class="view_image">
              <h2>写真ファイル</h2>
              <p><?php echo nl2br($_SESSION['photo'])?></p>
              
          </div>
          <div>
              <h2>ジャンル</h2>
              <p><?php echo ($_SESSION['genre']); ?></p>
          </div>
          <div class="PhotoComm">
              <h2>コメント</h2>
              <p class="photoComm"><?php echo nl2br($_SESSION['comment'])?></p>
          </div>
          <div class="other other1">
                  <div class="good">
                  <button type="button" onclick=history.back()>編集</button>
                  </div>
                  <div class="post_date">
                  <button type="submit" id="submit" name="submit">登録</button>
                  </div>
          </div>
        </form>
        
        
    </div>
    
  </section>
  <footer>
    <div class="footer_photo">
      <p></p>
    </div>
    
  </footer>
</body>
</html>