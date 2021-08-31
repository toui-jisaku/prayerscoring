<?php


require_once(ROOT_PATH .'Controllers/UserController.php');

$user = new UserController();

$login_user = $_SESSION['login_user'];
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
        <nav>
              <div class="logo">
                  <a href="login.php">
                      prayerscoring
                  </a>
              </div>
              <div class="sign">
                <a href="main.php">
                <?php echo htmlspecialchars($login_user['name'],ENT_QUOTES,"UTF-8"); ?>
                </a>
              </div>
              <div class="sign">
                <a href="post_index.php">
                      投稿一覧
                </a>
              </div>
              <div class="sign">
                  <form action="logout.php" method="post">
                        <input type="submit" name="logout" value="ログアウト">
                  </form>
              </div>
        </nav>
</body>
</html>