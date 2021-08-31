<?php
session_start();

require_once(ROOT_PATH .'Controllers/UserController.php');
require_once(ROOT_PATH .'Controllers/PhotoController.php');
require_once(ROOT_PATH .'Controllers/GoodController.php');

$user = new UserController();
$photo =new PhotoController();
$good =new GoodController();

$params = $photo->post_index_cat();
$result = $user->checkLogin();

if (!$result) {
    $_SESSION['login_err'] = 'ユーザを登録してログインしてください';
    header('Location: signup.php');
    return;
}
if($_SESSION['login_user']['role'] == 1) {
    header('Location: post_index_manager.php');
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
<script src=" https://code.jquery.com/jquery-3.4.1.min.js "></script>
  
 
  <script>
            
                // ここに処理を記述
                $(document).on('click','.favorite_btn',function(e){
                    e.stopPropagation();
                    var $this = $(this),
                        user_id = $('[name="user_id"]').val(),
                        photo_id = $this.parents('.photo').data('photo_id');;
                    $.ajax({
                        type: 'POST',
                        url: 'ajax_post_favorite_process.php',
                        dataType: 'text',
                        data: { user_id: user_id,
                                photo_id: photo_id}
                    }).done(function(data){
                        
                        location.reload();
                        
                    }).fail(function(XMLHttpRequest, textStatus, errorThrown) {
                        alert('通信失敗！');
                        console.log("XMLHttpRequest : " + XMLHttpRequest.status);
                        console.log("textStatus     : " + textStatus);
                        console.log("errorThrown    : " + errorThrown.message);
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
      <div class="photoGenre">
          <a href="post_index.php">全ての写真はこちら</a>
          <a href="post_index_dog.php">選手のみはこちら</a>
          <a href="post_index_dog_cat.php">監督のみはこちら</a>
      </div>
        <div class="big_photobox">
            <?php foreach($params['photo'] as $photo): ?>
                <div class="photobox">
                    <div class="user">
                        <?php 
                            $_SESSION['photo_id'] = $photo['id'];
                            
                        ?>
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
                    <section class="photo" data-photo_id="<?=$photo['id'] ?>">
                        <div class="other">
                            <div class="good">
                                <form class="favorite_count" action="" method="post">
                                        <input id="photo_id" type="hidden" name="photo_id" value="<?=$photo['id'] ?>">
                                        <input id="user_id" type="hidden" name="user_id" value="<?=$_SESSION['login_user']['id'] ?>">
                                        <button type="submit" name="favorite" class="favorite_btn">
                                        <?php if (!($good->check_favolite_duplicate())): ?>
                                        いいね
                                        <?php else: ?>
                                        いいね解除
                                        <?php endif; ?>
                                        </button>
                                </form>
                            </div>
                            <div class="post_date">
                                <p>投稿日時　<?=date('Y-m-d H:i',  strtotime($photo['created_at'])) ?></p>
                            </div>
                        </div>
                    </section>
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