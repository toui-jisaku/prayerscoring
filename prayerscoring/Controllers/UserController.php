<?php
require_once(ROOT_PATH . '/Models/User.php');

class UserController {
    private $request;   // リクエストパラメータ(GET,POST)
    private $User;    // Userモデル
    
    public function __construct() {
        // リクエストパラメータの取得
        $this->request['get'] = $_GET;
        $this->request['post'] = $_POST;

        // モデルオブジェクトの生成
        $this->User = new User();  
        // 別モデルと連携
        
    }

    public function validate_register(){
        if(isset($this->request['post'])) {
            $errmessage = $this->User->validate($this->request['post']);
            return $errmessage;
        }
        
    }

    public function register(){
        $this->User->createUser($this->request['post']);
    }

    

    public function login(){
        if(isset($this->request['post'])) {
            $errmessage = $this->User->login_user($this->request['post']);
            return $errmessage;
        }
        $user = $this->User->login_user($this->request['post']);
        $params = [
            'user' =>$user
        ];
        return $params;
    }

    public function checkLogin(){
        $result = $this->User->checkLog();
        return $result;
    }

    public function logout(){
        $this->User->logout_user();
    }

    public function validate_user_edit(){
        if(isset($this->request['post'])) {
            $errmessage = $this->User->validate($this->request['post']);
            return $errmessage;
        }
        
    }

    public function edit_User_confirm(){
        $this->User->edit_User_conf();
    }

    public function user_edit_complete(){
        $this->User->edit_User();
        $this->User->logout_user();
        // header("Location:login.php");
    }

    public function user_delete_complete(){
        $this->User->delete_User();
    }

    public function user_index(){
        $user = $this->User->findAllUsers();
        $params = [
            'user' => $user,
        ];
        return $params;
    }

    public function user_deleteBy_manager(){
        $this->User->delete_UserBy_manager();
    }

    public function good_user(){
        if(empty($this->request['get']['id'])) {
            echo '指定のパラメータが不正です。このページを表示できません。';
            exit;
        }

        $user = $this->User->findGoodUsers($this->request['get']['id']);
        $params = [
            'user' => $user
        ];
        return $params;
    }
}