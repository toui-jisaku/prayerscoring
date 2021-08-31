<?php
session_start();

require_once(ROOT_PATH .'Controllers/UserController.php');

$user = new UserController();

if(isset($_SESSION['errmessage'])){
  $errmessage = $_SESSION['errmessage'];
  unset($_SESSION['errmessage']);
}
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
  <title>選手・監督　投稿ページ</title>
  <link rel="stylesheet" type="text/css" href="/style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
</head>
<body>
  <header>
    <?php include dirname(__FILE__) . '/header1.php';?>
  </header>
  <section>
    <div class="err">
      <p>
          <?php if(isset($errmessage)): ?>
          <?php foreach($errmessage as $err): ?>
              <?php echo $err. "</br>"; ?>
          <?php endforeach; ?>
          <?php endif; ?>
      </p>
    </div>
    <div class="main">
        <p><?php echo htmlspecialchars($login_user['name'],ENT_QUOTES,"UTF-8"); ?>さんの投稿どうぞ♡</p>
        <form enctype="multipart/form-data" action="photo_confirm_post.php" method="post">
          <div class="photo">
            <h2>写真を選択</h2>
            <input type="hidden" name="MAX_FILE_SIZE" value="" />
            <input type="file" name="photo" accept="image/*" required>
          </div>
          <div>
              <h2>ジャンル</h2>
              <input type="radio" name="genre" value="選手">選手
              <input type="radio" name="genre" value="監督">監督
              <input type="radio" name="genre" value="その他">その他
          </div>
          <div>
              <h2>コメント</h2>
              <textarea name="comment" id="comment" value="" cols="30" rows="10"></textarea>
          </div>
          <div>
              <button type="submit">確認</button>
          </div>
        </form>
        
    </div>
    
  </section>
  <footer>
    <div class="footer_photo">
      <p>悪口言い過ぎ禁止しております</p>
    </div>
    
  </footer>
</body>
</html>