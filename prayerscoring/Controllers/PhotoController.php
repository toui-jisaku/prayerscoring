<?php
require_once(ROOT_PATH . '/Models/Photo.php');

class PhotoController {
    private $request;   // リクエストパラメータ(GET,POST)
    private $Photo;    // Photoモデル
    
    public function __construct() {
        // リクエストパラメータの取得
        $this->request['get'] = $_GET;
        $this->request['post'] = $_POST;

        // モデルオブジェクトの生成
        $this->Photo = new Photo();  
        // 別モデルと連携
        
    }

    public function photo_postValidate(){
        if(isset($this->request['post'])) {
            $errmessage = $this->Photo->photo_post_validate($this->request['post']);
            return $errmessage;
        }
    }
    public function photo_post_confirm(){
        if(isset($this->request['post'])) {
            $errmessage = $this->Photo->photo_post_conf($this->request['post']);
            return $errmessage;
        }
    }

    public function post_complete(){
        $this->Photo->post_comp();
    }

    public function main_post(){
        $page = 0;
        if(isset($this->request['get']['page'])) {
            $page = $this->request['get']['page'];
        }
        $photos = $this->Photo->findAllByUser($page);
            $photos_count = $this->Photo->countAllByUser();
            $params = [
                'photos' => $photos,
                'pages' => $photos_count / 4,
            ];
            return $params;
            
    }

    public function view() {
        if(empty($this->request['get']['id'])) {
            echo '指定のパラメータが不正です。このページを表示できません。';
            exit;
        }

        $photo = $this->Photo->findByID($this->request['get']['id']);
        
        $params = [
            'photo' => $photo,
        ];
        return $params;
    }

    public function delete_photo(){
        $this->Photo->delete();
    }

    public function photo_edit_confirm(){
        $this->Photo->photo_edit_conf();
    }

    public function photo_edit_complete(){
        $this->Photo->photo_edit_comp();
    }

    public function post_index(){
        $photo = $this->Photo->findAll();
        $params = [
            'photo' => $photo,
        ];
        return $params;
    }

    public function post_index_dog(){
        $photo = $this->Photo->findAll_dog();
        $params = [
            'photo' => $photo,
        ];
        return $params;
    }

    public function post_index_cat(){
        $photo = $this->Photo->findAll_cat();
        $params = [
            'photo' => $photo,
        ];
        return $params;
    }

    public function post_index_dog_cat(){
        $photo = $this->Photo->findAll_dog_cat();
        $params = [
            'photo' => $photo,
        ];
        return $params;
    }
}