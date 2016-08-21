<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/20
 * Time: 17:38
 */

class UserController extends CController {
    public function actionAddUser() {
        $a = file_get_contents("php://input");
        $b = json_decode($a, true);
        $b['name'] .= "aaa";
        $b['age'] += 1;
        echo json_encode($b);
    }

}