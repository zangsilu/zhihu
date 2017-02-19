<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Request;

class User extends Model
{
    public $table = 'users';

    public function register()
    {
        $username = Request::get('username');
        $password = Request::get('password');

        /*检查用户名与密码是否为空*/
        if (empty($username) || empty($password)) {
            return ['status' => 1, 'msg' => '用户名或密码不能为空'];
        }

        /*检查用户名是否重复*/
        if($this->where(['username'=>$username])->exists()){
            return ['status' => 1, 'msg' => '用户名已存在'];
        }

        /*加密密码*/
        $hashed_password = bcrypt($password);

        /*保存*/
        $this->username = $username;
        $this->password = $hashed_password;
        if($this->save()){
            return ['status' => 1, 'msg' => '注册成功'];
        }else{
            return ['status' => 1, 'msg' => '注册失败'];
        }
    }
}
