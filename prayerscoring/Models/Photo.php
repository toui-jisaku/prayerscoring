<?php
require_once(ROOT_PATH .'/Models/Db.php');

class Photo extends Db {
    
    public function __construct($dbh = null){
        parent::__construct($dbh);
    }


    public function photo_post_validate($post){
        $errmessage = [];
        // if ($post["photo"] == "") {
        //     $errmessage['photo'] = "ファイルが選択されていません";
        // }
        if ($post["genre"] == "") {
                $errmessage['genre'] = "ジャンルが選択されていません";
        }
        if ($post["comment"] == "") {
            $errmessage['comment'] = "コメントが空白です";
        }
        return $errmessage;
    }
    public function photo_post_conf(){
        //ファイル関連の取得
        $file = $_FILES['photo'];
        $filename = basename($file['name']);
        $tmp_path = $file['tmp_name'];
        $file_err = $file['error'];
        $filesize = $file['size'];
        $upload_dir = 'img2/';
        $save_filename = date('YmdHis') . $filename;
        $save_path = $upload_dir . $save_filename;
        move_uploaded_file($tmp_path, $save_path);
        $_SESSION['photo'] = htmlspecialchars($filename,ENT_QUOTES,"UTF-8");
        $_SESSION['file_path'] = $save_path;
        $_SESSION['genre'] = htmlspecialchars($_POST['genre'],ENT_QUOTES,"UTF-8");
        $_SESSION['comment'] = htmlspecialchars($_POST['comment'],ENT_QUOTES,"UTF-8");
    }

    public function post_comp(){
        $photo = $_SESSION['photo'];
        $file_path = $_SESSION['file_path'];
        $genre = $_SESSION['genre'];
        $comment = $_SESSION['comment'];

        $sql = "INSERT INTO photos (file_name, file_path, genre, comment) VALUES (:file_name, :file_path, :genre, :comment)";
        $stmt = $this->dbh->prepare($sql);
        $params = array(':file_name' => $photo, ':file_path' => $file_path, ':genre' => $genre, ':comment' => $comment);
        $stmt->execute($params);

        $login_user = $_SESSION['login_user'];
        $photo_id = $this->dbh->lastInsertId();
        $sql = "INSERT INTO users_photos (user_id, photo_id) VALUES (:user_id, :photo_id)";
        $stmt = $this->dbh->prepare($sql);
        $params = array(':user_id' => $login_user['id'], ':photo_id' => $photo_id);
        $stmt->execute($params);
    }
    /**
     * photosテーブルからすべてデータを取得（4件ごと）
     * 
     * @param integer $page ページ番号
     * @return Array ログインユーザが投稿したデータ
     */
    public function findAllByUser($page = 0):Array {
        $sql = 'SELECT photos.* FROM photos JOIN users_photos ON users_photos.photo_id = photos.id 
                WHERE users_photos.user_id = :id';
        $sql .= ' LIMIT 4 OFFSET '.(4 * $page);
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':id', $_SESSION['login_user']['id'], PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    /**
     * photosテーブルからログインユーザが投稿した全データ数を取得
     * 
     * @return Int $count ログインユーザが投稿したデータの件数
     */
    public function countAllByUser():Int {
        $sql = 'SELECT count(*) as count FROM photos JOIN users_photos ON users_photos.photo_id = photos.id
                WHERE users_photos.user_id = :id';
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':id', $_SESSION['login_user']['id'], PDO::PARAM_INT);
        $sth->execute();
        $count = $sth->fetchColumn();
        return $count;
    }
    
    /**
     * photosテーブルからidに基づいてデータを取得
     * 
     * @param integer $id フォトのID
     * @return Array $result 指定のフォトデータ
     */
    public function findByID($id = 0):Array {
        $sql = 'SELECT photos.* FROM photos ';
        $sql .= ' WHERE photos.id = :id';
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * photosテーブルからidに基づいてデータを削除
     * users_photosテーブルからidに基づいてデータを削除
     * 
     * @param integer $id フォトのID
     */
    public function delete(){
        $sql = "DELETE FROM photos WHERE photos.id=:id";
            
        $stmh = $this->dbh->prepare($sql);
        $stmh->execute(array(':id' => $_SESSION['id']));

        $sql = "DELETE FROM users_photos WHERE users_photos.photo_id=:id";
            
        $stmh = $this->dbh->prepare($sql);
        $stmh->execute(array(':id' => $_SESSION['id']));
    }

    public function photo_edit_conf(){
        //ファイル関連の取得
        $_SESSION['genre'] = htmlspecialchars($_POST['genre'],ENT_QUOTES,"UTF-8");
        $_SESSION['comment'] = htmlspecialchars($_POST['comment'],ENT_QUOTES,"UTF-8");
    }

    public function photo_edit_comp(){
        $genre = $_SESSION['genre'];
        $comment = $_SESSION['comment'];
        $id = $_SESSION['id'];

        $sql = "UPDATE photos SET genre = :genre, comment = :comment WHERE photos.id = :id";
        $stmt = $this->dbh->prepare($sql);
        $params = array(':genre' => $genre, ':comment' => $comment, ':id' => $id);
        $stmt->execute($params);

        $login_user = $_SESSION['login_user'];
        $photo_id = $this->dbh->lastInsertId();
        $sql = "INSERT INTO users_photos (user_id, photo_id) VALUES (:user_id, :photo_id)";
        $stmt = $this->dbh->prepare($sql);
        $params = array(':user_id' => $login_user['id'], ':photo_id' => $photo_id);
        $stmt->execute($params);
    }

    /**
     * photosテーブルからすべてデータを取得 usersテーブルからユーザーネームを取得（全て）
     * 
     * 
     * @return Array オールユーザが投稿したデータ
     */
    public function findAll():Array {
        $sql = 'SELECT photos.*, users.name AS user_name FROM photos JOIN users_photos ON users_photos.photo_id = photos.id JOIN users ON users.id = user_id ORDER BY photos.created_at DESC'; 
                
        
        $sth = $this->dbh->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * photosテーブルからすべてデータを取得 usersテーブルからユーザーネームを取得（犬）
     * 
     * 
     * @return Array オールユーザが投稿したデータ
     */
    public function findAll_dog():Array {
        $sql = 'SELECT photos.*, users.name AS user_name FROM photos JOIN users_photos ON users_photos.photo_id = photos.id JOIN users ON users.id = user_id WHERE photos.genre = "選手" ORDER BY photos.created_at DESC'; 
                
        
        $sth = $this->dbh->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * photosテーブルからすべてデータを取得 usersテーブルからユーザーネームを取得（猫）
     * 
     * 
     * @return Array オールユーザが投稿したデータ
     */
    public function findAll_cat():Array {
        $sql = 'SELECT photos.*, users.name AS user_name FROM photos JOIN users_photos ON users_photos.photo_id = photos.id JOIN users ON users.id = user_id WHERE photos.genre = "監督" ORDER BY photos.created_at DESC'; 
                
        
        $sth = $this->dbh->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * photosテーブルからすべてデータを取得 usersテーブルからユーザーネームを取得（犬猫）
     * 
     * 
     * @return Array オールユーザが投稿したデータ
     */
    public function findAll_dog_cat():Array {
        $sql = 'SELECT photos.*, users.name AS user_name FROM photos JOIN users_photos ON users_photos.photo_id = photos.id JOIN users ON users.id = user_id WHERE photos.genre = "その他" ORDER BY photos.created_at DESC'; 
                
        
        $sth = $this->dbh->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}