<?php
require_once(ROOT_PATH .'/Models/Db.php');

class User extends Db {
    private $table = 'users';
    public function __construct($dbh = null){
        parent::__construct($dbh);
    }


    public function validate($post){
        $errmessage = [];
        
            if ($post["name"] == "") {
            $errmessage['name'] = "ユーザーネームが空白です";
            }
            if ($post["email"] == "") {
              $errmessage['email'] = "メールアドレスが空白です";
            } else if (!preg_match("/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/",$post["email"])){
                $errmessage['email_form'] = 'メールアドレスは正しくご入力ください';
            }
            
            $password = filter_input(INPUT_POST, 'password');
            //正規表現
            if (!preg_match("/\A[a-z\d]{8,100}+\z/i",$password)){
                $errmessage['password'] = "パスワードは英数字8文字以上100文字以下にしてください。";
            }
            $password_conf = filter_input(INPUT_POST, 'password_conf');
            if ($password !== $password_conf){
                $errmessage['password_conf'] = "確認用パスワードと異なっています。";
            }
        
        return $errmessage;
    }
    /**
     * usersテーブルにユーザを登録する
     * 
     * @param array $post 
     */
    public function createUser($post){
        
        
            $sql = 'INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, :role)';
            $sth = $this->dbh->prepare($sql);
            $sth->bindValue(':name', htmlspecialchars($post['name'],ENT_QUOTES,"UTF-8"), PDO::PARAM_STR);
            $sth->bindValue(':email', htmlspecialchars($post['email'],ENT_QUOTES,"UTF-8"), PDO::PARAM_STR);
            $hash = password_hash($post['password'], PASSWORD_DEFAULT);
            $sth->bindParam(':password', $hash, PDO::PARAM_STR);
            $sth->bindValue(':role', 0, PDO::PARAM_INT);
            $sth->execute();
           
    }

    

    /**
     * ログイン処理
     * 
     */
    public function login_user($post){
        $sql = 'SELECT * FROM users WHERE email = :email';
            $sth = $this->dbh->prepare($sql);
            $sth->bindValue(':email', htmlspecialchars($post['email'],ENT_QUOTES,"UTF-8"), PDO::PARAM_STR);
            $sth->execute();
            $result = $sth->fetch(PDO::FETCH_ASSOC);
            $errmessage = [];
            if (!$result){
                $errmessage['email'] = "メールアドレスが一致しません";
            }
        if (password_verify($post['password'], $result['password'])){
            session_regenerate_id(true);
            $_SESSION['login_user'] = $result;
        }else{
            $errmessage['password'] = "パスワードが一致しません";
        }
        return $errmessage;
    }

    /**
     * ログイン確認
     * 
     */
    public function checkLog(){
        $result = false;

        if (isset($_SESSION['login_user']) && $_SESSION['login_user']['id'] > 0){
            return $result = true;
        }

        return $result;
    }
    /**
     * ログアウト
     * 
     */
    public function logout_user(){
        $_SESSION = array();
        session_destroy();
    }

    public function edit_User_conf(){
        //ファイル関連の取得
        $_SESSION['name'] = htmlspecialchars($_POST['name'],ENT_QUOTES,"UTF-8");
        $_SESSION['email'] = htmlspecialchars($_POST['email'],ENT_QUOTES,"UTF-8");
        $_SESSION['password'] = htmlspecialchars($_POST['password'],ENT_QUOTES,"UTF-8");
    }


    /**
     * usersテーブルにユーザを登録する
     * 
     * @param array $post 
     */
    public function edit_User(){
        $name = $_SESSION['name'];
        $email = $_SESSION['email'];
        $password = $_SESSION['password'];
        
        $sql = "UPDATE users SET name = :name, email = :email, password = :password WHERE users.id = :id";
        $sth = $this->dbh->prepare($sql);
        $sth->bindValue(':name', $name, PDO::PARAM_STR);
        $sth->bindValue(':email', $email, PDO::PARAM_STR);
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $sth->bindParam(':password', $hash, PDO::PARAM_STR);
        $login_user = $_SESSION['login_user'];
        $sth->bindParam(':id', $login_user['id'], PDO::PARAM_STR);
        $sth->execute();
        $login_user['name'] = $name;
        $login_user['email'] = $email;
        $login_user['password'] = $password;
       
    }

    /**
     * photosテーブルからidに基づいてデータを削除
     * users_photosテーブルからidに基づいてデータを削除
     * usersテーブルからidに基づいてデータを削除
     * 
     * @param integer $id フォトのID
     */
    public function delete_User(){
        $login_user = $_SESSION['login_user'];
        
        $sql = "DELETE users_photos, photos FROM users_photos JOIN photos ON users_photos.photo_id = photos.id WHERE users_photos.user_id=:id";
            
        $stmh = $this->dbh->prepare($sql);
        $stmh->execute(array(':id' => $login_user['id']));

        

        $sql = "DELETE FROM users WHERE users.id=:id";
            
        $stmh = $this->dbh->prepare($sql);
        $stmh->execute(array(':id' => $login_user['id']));

        session_destroy();
    }

    /**
     * usersテーブルからrole==0のすべてのデータを取得 
     * 
     * 
     * @return Array ユーザデータ
     */
    public function findAllUsers():Array {
        $sql = 'SELECT users.* FROM users WHERE users.role = 0'; 
                
        
        $sth = $this->dbh->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * usersテーブルからいいねしたユーザのnameを取得 
     * 
     * 
     * @return Array ユーザデータ
     */
    public function findGoodUsers($id = 0):Array {
        $sql = 'SELECT users.* FROM users JOIN goods ON goods.user_id = users.id WHERE users.id = goods.user_id AND goods.photo_id = :p_id'; 
                
        
        $sth = $this->dbh->prepare($sql);
        $sth->execute(array(':p_id' => $id));
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * photosテーブルからidに基づいてデータを削除
     * users_photosテーブルからidに基づいてデータを削除
     * usersテーブルからidに基づいてデータを削除
     * 
     * @param integer $id フォトのID
     */
    public function delete_UserBy_manager(){
        
        
        $sql = "DELETE users_photos, photos FROM users_photos JOIN photos ON users_photos.photo_id = photos.id WHERE users_photos.user_id=:id";
            
        $stmh = $this->dbh->prepare($sql);
        $stmh->execute(array(':id' => $_SESSION['id']));

        

        $sql = "DELETE FROM users WHERE users.id=:id";
            
        $stmh = $this->dbh->prepare($sql);
        $stmh->execute(array(':id' => $_SESSION['id']));

        
    }
}