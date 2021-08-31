<?php
session_start();

require_once(ROOT_PATH .'Controllers/UserController.php');
require_once(ROOT_PATH .'Controllers/PhotoController.php');

$user = new UserController();
$photo =new PhotoController();

$params = $photo->post_index();
$result = $user->checkLogin();

if (!$result) {
    $_SESSION['login_err'] = 'ユーザを登録してログインしてください';
    header('Location: signup.php');
    return;
}
if($_SESSION['login_user']['role'] == 0) {
    header('Location: post_index.php');
}
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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script>
            $(function(){
                // ここに処理を記述
                $('.del_btn').on("click", function(){
                    var select = confirm("本当に削除しますか？「OK」で削除「キャンセル」で削除中止");
                    return select;
                });
            });
        </script>
</head>
<body>
  <header>
    <?php include dirname(__FILE__) . '/header1.php';?>
  </header>
  <section>
  <h1>最近追加された写真</h1>
    <div class="big_photobox">
        <?php foreach($params['photo'] as $photo): ?>
            <?php 
            $_SESSION['id'] = $photo['id'];
            ?>
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
                        <p>コメント</p>
                        <p><?=$photo['comment'] ?></p>
                    </div>    
                    
                </div>
                <div class="other">
                    <div class="del_btn">
                        <?php echo "<a href=photo_delete_confirm.php?id=" . $photo["id"] .">削除</a>";?>
                    </div>
                    <div class="post_date">
                        <p><?=$photo['created_at'] ?></p>
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