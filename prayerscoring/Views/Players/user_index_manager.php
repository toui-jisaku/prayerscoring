<?php
session_start();

require_once(ROOT_PATH .'Controllers/UserController.php');
require_once(ROOT_PATH .'Controllers/PhotoController.php');

$user = new UserController();
$photo =new PhotoController();

$params = $user->user_index();
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
  <title>prayerscoring　ユーザー一覧</title>
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
  <h1>ユーザー一覧</h1>
  <h2><a href="main_manager.php">管理者メインページに戻る</a></h2>
    <?php foreach($params['user'] as $user): ?>
        <div class="photobox">
            <div class="user">
                <div class="user_name">
                    ユーザネーム：<?=$user['name'] ?>  
                    <div class="user_email">
                        メールアドレス：<?=$user['email'] ?>
                    </div>
                </div>
                
            </div>
            <div class="del_btn">
              <a href="user_deleteBy_manager.php">削除</a> 
              <?php 
                $_SESSION['id'] = $user['id'];
              ?>       
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