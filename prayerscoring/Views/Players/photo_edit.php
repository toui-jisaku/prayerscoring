<?php
session_start();

require_once(ROOT_PATH .'Controllers/UserController.php');
require_once(ROOT_PATH .'Controllers/PhotoController.php');

$user = new UserController();
$photo =new PhotoController();

$params = $photo->view();
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
  <title>投稿編集ページ</title>
  <link rel="stylesheet" type="text/css" href="/style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body>
  <header>
    <?php include dirname(__FILE__) . '/header1.php';?>
  </header>
  <section>
    <?php foreach($params['photo'] as $photo): ?>
    <div class="main">
        <p><?php echo htmlspecialchars($login_user['name'],ENT_QUOTES,"UTF-8"); ?>さんの投稿の編集</p>
        <form enctype="multipart/form-data" action="photo_confirm_edit.php" method="post">
        <div class="view_image">
            <img src="<?php echo "/"."{$photo['file_path']}"; ?>" alt="" width="300px" height="200px">
            <?php $_SESSION['file_path'] = $photo['file_path'];
                  $_SESSION['id'] = $photo['id'];
             ?>
        </div>
          <div>
              <h2>ジャンル</h2>
              <input type="radio" name="genre" value="選手" <?= $photo['genre'] == '選手' ?"checked":"" ?>>選手
              <input type="radio" name="genre" value="監督" <?= $photo['genre'] == '監督' ?"checked":"" ?>>監督
              <input type="radio" name="genre" value="その他" <?= $photo['genre'] == 'その他' ?"checked":"" ?>>その他
          </div>
          <div>
              <h2>コメント</h2>
              <textarea name="comment" id="comment" value="" cols="30" rows="10"><?=$photo['comment'] ?></textarea>
          </div>
          <div>
              <button type="submit">確認</button>
          </div>
        </form>
        
    </div>
    <?php endforeach; ?>
  </section>
  <footer>
    <div class="footer_photo">
      <p></p>
    </div>
    
  </footer>
</body>
</html>