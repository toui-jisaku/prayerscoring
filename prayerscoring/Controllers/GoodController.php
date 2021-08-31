<?php
require_once(ROOT_PATH . '/Models/Good.php');

class GoodController {
    private $request;   // リクエストパラメータ(GET,POST)
    private $good;    // Photoモデル
    
    public function __construct() {
        // リクエストパラメータの取得
        $this->request['get'] = $_GET;
        $this->request['post'] = $_POST;

        // モデルオブジェクトの生成
        $this->Good = new Good();  
        // 別モデルと連携
        
    }

    public function check_favolite_duplicate(){
        $favorite = $this->Good->check_favolite_dup();
        return $favorite;
        
    }
    public function check_favolite_duplicate2(){
        $favorite = $this->Good->check_favolite_dup2();
        return $favorite;
        
    }

    public function count_good(){
        if(empty($this->request['get']['id'])) {
            echo '指定のパラメータが不正です。このページを表示できません。';
            exit;
        }
        $good_count = $this->Good->countGood($this->request['get']['id']);
            $param = [
                'goods' => $good_count,
            ];
            return $param;
    }


    public function delete_good(){
        $this->Good->del_good();
    }

    public function insert_good(){
        $this->Good->ins_good();
    }

 
}