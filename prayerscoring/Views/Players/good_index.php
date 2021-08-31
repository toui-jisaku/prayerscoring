<?php
session_start();

require_once(ROOT_PATH .'Controllers/UserController.php');
require_once(ROOT_PATH .'Controllers/PhotoController.php');
require_once(ROOT_PATH .'Controllers/GoodController.php');

$user = new UserController();
$photo =new PhotoController();
$good =new GoodController();

$result = $user->checkLogin();
$user_names = $user->good_user();

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
  <title>　いいね！したユーザ一覧</title>
  <link rel="stylesheet" type="text/css" href="/style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body>
  <header>
    <?php include dirname(__FILE__) . '/header1.php';?>
  </header>
  <section>
  <h1>いいね！したユーザー一覧</h1>
  <div class="big_photobox">
        <?php foreach($user_names['user'] as $user_name): ?>
            <div class="photobox">
                <div class="user">
                    <div class="user_name">
                        ユーザネーム：<?=$user_name['name'] ?>
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