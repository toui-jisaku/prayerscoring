<?php
session_start();
require_once(ROOT_PATH .'Controllers/UserController.php');
$user = new UserController();
$errmessage = $user->validate_user_edit();

$user->edit_User_confirm();
if(count($errmessage) !== 0) {
    $_SESSION['errmessage'] = $errmessage;
    $_SESSION['user']['email'] = $_POST['email'];
    $_SESSION['user']['password'] = $_POST['password'];
    $_SESSION['user']['password_conf'] = $_POST['password_conf'];
    header("Location:user_edit.php");
}// else {
//     $post = $user->user_edit_complete();
// }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>prayerscoring　アカウント編集確認</title>
  <link rel="stylesheet" type="text/css" href="/style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body>
  <header>
    <?php include dirname(__FILE__) . '/header1.php';?>
  </header>
  <section>
    <div class="main">
        <p>アカウント編集確認</p>
        <div>
            <label>ユーザーネーム：<?php echo $_SESSION['name'] ?><label>
            
        </div>
        <div>
            <label>メールアドレス：<?php echo $_SESSION['email'] ?><label>
            
        </div>
        <div>
            <label>パスワード：<?php echo str_repeat("*", mb_strlen($_SESSION['password'], "UTF8")); ?><label>   
        </div>
        <div>
            <button type="button" onclick=history.back()>アカウント編集ページへ戻る</button>
        </div>
        <div>
            <a href="user_edit_complete.php">登録する</a>
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