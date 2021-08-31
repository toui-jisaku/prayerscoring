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

$login_user = $_SESSION['login_user'];
if($login_user['role'] == 1) {
    header('Location: main_manager.php');
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>prayerscoring　メインページ</title>
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
        <div>
            <label>ユーザーネーム：<?php echo htmlspecialchars($login_user['name'],ENT_QUOTES,"UTF-8"); ?><label>
        </div>
        <div>
            <label>メールアドレス：<?php echo htmlspecialchars($login_user['email'],ENT_QUOTES,"UTF-8"); ?><label>
        </div>
        <div>
            <a href="user_edit.php">アカウント情報を編集する</a>
        </div>
    </div>
    <div class="bigbox">
        <?php foreach($params['photos'] as $photo): ?>
            <div class="box">
                <div class="minbox">
                    <div>
                        <img src="<?php echo "/"."{$photo['file_path']}"; ?>" alt="" width="80px" height="60px"> 
                    </div>
                    <div>
                        <label>投稿日：<label>
                        <?=date('Y-m-d',  strtotime($photo['created_at'])) ?>
                    </div>
                    <div>
                    <?php echo "<a href=photo.php?id=" . $photo["id"] .">詳しく見る</a>";?>
                    <?php 
                    $_SESSION['photo_id'] = $photo['id'];
                    
                    ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        
    </div>
    <div class='paging'>
        <?php
        for($i=0;$i<=$params['pages'];$i++) {
            if(isset($_GET['page']) && $_GET['page'] == $i) {
                echo $i+1;
            } else {
                echo "<a href='?page=".$i."'>".($i+1)."</a>";
            }
        }
        ?>
    </div>
    <div class="mainPost"> 
        <a href="post.php">写真を投稿する</a>
    </div>
  </section>
  <footer>
    <div class="footer_photo">
    <span class="blink">ロナウジーニョの現在の年齢41歳</span>
    </div>
    
  </footer>
</body>
</html>