<?php
session_start();

require_once(ROOT_PATH .'Controllers/UserController.php');
require_once(ROOT_PATH .'Controllers/PhotoController.php');
require_once(ROOT_PATH .'Controllers/GoodController.php');

$user = new UserController();
$photo =new PhotoController();
$good =new GoodController();

$params = $photo->view();
$param = $good->count_good();
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
  <title>投稿詳細</title>
  <link rel="stylesheet" type="text/css" href="/style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body>
  <header>
    <?php include dirname(__FILE__) . '/header1.php';?>
  </header>
  <section>
  <?php foreach($params['photo'] as $photo): ?>
    <div class="main photoMain">
        <p><?php echo htmlspecialchars($login_user['name'],ENT_QUOTES,"UTF-8"); ?>さんの投稿</p>
        <div class="view_image">
            <img src="<?php echo "/"."{$photo['file_path']}"; ?>" alt="" width="300px" height="200px">
        </div>
        <div>
            <h2>ジャンル</h2>
            <p><?=$photo['genre'] ?></p>
        </div>
        <div class="PhotoComm">
            <h2>コメント</h2>
            <p class="photoComm"><?=nl2br($photo['comment']) ?></p>
        </div>
        <div>
            <h2>いいね！</h2>
            <?php echo "<a href=good_index.php?id=" . $photo["id"] .">".$param['goods'] ."件</a>";?>
            
        </div>
        <div>
            <?php echo "<a href=photo_edit.php?id=" . $photo["id"] .">ジャンル・コメントを編集</a>";?>
        </div>
        <div>
            <?php echo "<a href=photo_delete_confirm.php?id=" . $photo["id"] .">削除</a>";?>
        </div>
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