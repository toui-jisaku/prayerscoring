<?php
session_start();

require_once(ROOT_PATH .'Controllers/UserController.php');
require_once(ROOT_PATH .'Controllers/PhotoController.php');

$user = new UserController();
$photo =new PhotoController();

$params = $photo->post_index();
// $result = $user->checkLogin();

// if (!$result) {
//     $_SESSION['login_err'] = 'ユーザを登録してログインしてください';
//     header('Location: signup.php');
//     return;
// }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>投稿一覧</title>
  <link rel="stylesheet" type="text/css" href="/style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body>
  <header>
    <?php include dirname(__FILE__) . '/header.php';?>
  </header>
  <section>
  <h1>最近追加された写真</h1>
  <div class="big_photobox">
        <?php foreach($params['photo'] as $photo): ?>
            <div class="photobox">
                <div class="user">
                    <div class="user_name">
                        ユーザネーム：<?=$photo['user_name'] ?>
                    </div>
                </div>
                <div class="photos">
                    <div class="photo_image">
                        <img src="<?php echo "/"."{$photo['file_path']}"; ?>" width="300px" height="200px" alt="">
                        <div class="ganre">
                            <p>ジャンル：<?=$photo['genre'] ?></p>
                        </div>
                    </div>
                    <div class="comment">
                        <p class="comm">コメント</p>
                        <p class="mainComm"><?=nl2br($photo['comment']) ?></p>
                    </div>    
                    
                </div>
                <div class="other">
                    <div class="post_date">
                      <p>投稿日時　<?=date('Y-m-d H:i',  strtotime($photo['created_at'])) ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        
    </div>
  </section>
  <footer>
    <div class="footer_photo">
      <p></p>
    </div>
    
  </footer>
</body>
</html>