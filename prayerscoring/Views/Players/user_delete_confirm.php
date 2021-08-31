<?php
session_start();
require_once(ROOT_PATH .'Controllers/UserController.php');
$user = new UserController();
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
  <title>アカウント削除確認</title>
  <link rel="stylesheet" type="text/css" href="/style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script>
            $(function(){
                // ここに処理を記述
                $('.del_btn').on("click", function(){
                    var select = confirm("本当に削除しますか？「OK」で削除「キャンセル」で削除中止,もう一度考え直しませんか？");
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
    <div class="main">
        <p>アカウント削除確認</p>
        <div>
            <label>ユーザーネーム：<?php echo htmlspecialchars($login_user['name'],ENT_QUOTES,"UTF-8"); ?><label>
        </div>
        <div>
            <label>メールアドレス：<?php echo htmlspecialchars($login_user['email'],ENT_QUOTES,"UTF-8"); ?><label>
        </div>
        <div>
          <button type="button" onclick=history.back()>アカウント編集ページへ戻る</button>
        </div>
        <div class="del_btn">
            <a href="user_delete_complete.php">削除する</a>
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