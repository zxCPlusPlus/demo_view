<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/20
 * Time: 17:38
 */

class UserController extends CController {
    public function actionAddUser() {
        $b = $this->getPostParamsJson();
        if(empty($b['name']) || empty($b['age']) ){
            echo urldecode(json_encode(array('ret' => 0, 'msg' => '参数错误')));
            exit;
        }

        $url = 'http://demoapi/user/adduser';
        $ret = $this->sendPostRequest($url, $b);
        if($ret === false) {
            echo urldecode(json_encode(array('ret' => 0, 'msg' => '请求发送失败')));
        }
        echo $ret;
        //发送成功返回
        //{"code":1,"data":[true]}
    }
    
    public function actionGetUser() {
        $params = $this->getGetParams();
        $url = 'demoapi/user/finduser';
        $ret = $this->sendPostRequest($url, $params);
        if($ret === false) {
            echo urldecode(json_encode(array('ret' => 0, 'msg' => '请求发送失败')));
        }
        if(is_string($ret)) {
            echo $ret;
        }
        else {
            echo json_encode($ret);    
        }
    }

    public function getPostParamsJson() {
        $a = file_get_contents("php://input");
        $b = json_decode($a, true);
        if($b === false) {
            return array();
        }
        else {
            return $b;
        }
    }

    public function getPostParamsFormdata() {
        return $_POST;    
    }

    public function getGetParams() {
        return $_GET;
    }

    public function sendPostRequest($url, $data)
    {
        if(empty($url)) {
            return array('ret' => 0, 'msg' => '参数错误');
        }

        if(!is_array($data)) {
            return array('ret' => 0, 'msg' => '参数错误');
        }

        $jsonData = json_encode($data);
        if($jsonData === false) {
            return array('ret' => 0, 'msg' => '参数转换为json格式失败');
        }

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_TIMEOUT,3);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER,
            array('Content-Type: application/json', 'Content-Length:'.strlen($jsonData)));

        $sendRet = curl_exec($ch);

        curl_close($ch);

        return $sendRet;
    }
}
