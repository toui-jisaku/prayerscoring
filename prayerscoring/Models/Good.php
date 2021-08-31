<?php
require_once(ROOT_PATH .'/Models/Db.php');

class Good extends Db {
    
    public function __construct($dbh = null){
        parent::__construct($dbh);
    }


    public function check_favolite_dup() {
        
        $sql = "SELECT *
                FROM goods
                WHERE user_id = :user_id AND photo_id = :photo_id";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array(':user_id' => $_SESSION['login_user']['id'] ,
                             ':photo_id' => $_SESSION['photo_id']));
        $favorite = $stmt->fetch();
        return $favorite;
    }
    public function check_favolite_dup2() {
        $user_id = $_POST['user_id'];
        $photo_id = $_POST['photo_id'];
        $sql = "SELECT *
                FROM goods
                WHERE user_id = :user_id AND photo_id = :photo_id";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array(':user_id' => $user_id ,
                             ':photo_id' => $photo_id));
        $favorite = $stmt->fetch();
        return $favorite;
    }

    public function del_good() {
        $user_id = $_POST['user_id'];
        $photo_id = $_POST['photo_id'];
        $sql = "DELETE
        FROM goods
        WHERE :user_id = user_id AND :photo_id = photo_id";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array(':user_id' => $user_id , ':photo_id' => $photo_id));
    }

    public function ins_good() {
        $user_id = $_POST['user_id'];
        $photo_id = $_POST['photo_id'];
        $sql = "INSERT INTO goods(user_id,photo_id)
              VALUES(:user_id,:photo_id)";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(array(':user_id' => $user_id , ':photo_id' => $photo_id));
    }

 

    /**
     * playersテーブルからログインユーザが閲覧できる全データ数を取得
     * 
     * @return Int $count 全選手の件数
     */
    public function countGood($id = 0):Int {
        $sql = 'SELECT count(*) as count FROM goods
                WHERE photo_id = :photo_id';
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':photo_id', $id, PDO::PARAM_INT);
        $sth->execute();
        $count = $sth->fetchColumn();
        return $count;
    }
}