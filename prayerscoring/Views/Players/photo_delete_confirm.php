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
if($login_user['role'] == 1) {
  header('Location: photo_delete_complete.php');
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>投稿削除確認ページ</title>
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
  <?php foreach($params['photo'] as $photo): ?>
    <div class="main confirm_edit">
        <p><?php echo htmlspecialchars($login_user['name'],ENT_QUOTES,"UTF-8"); ?>さんの投稿の削除</p>
        <div class="view_image">
          <img src="<?php echo "/"."{$photo['file_path']}"; ?>" alt="" width="300px" height="200px">
        </div>
        <div>
            <h2>ジャンル</h2>
            <p><?=$photo['genre'] ?></p>
        </div>
        <div>
            <h2>コメント</h2>
            <p><?=$photo['comment'] ?></p>
        </div>
        <div class="other other1">
                <div class="good">
                    <button type="button" onclick=history.back()>戻る</button>
                </div>
                <div class="del_btn">
                    <a href="photo_delete_complete.php">削除</a>
                </div>
        </div>
          <?php 
            $_SESSION['id'] = $photo['id'];
          ?>
        
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