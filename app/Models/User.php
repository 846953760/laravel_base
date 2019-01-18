<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class User extends Model
{
    //使用原生DBsql操作
    public function select_sql($id){
    	$sql = 'select * from talk_worker where id = '.$id;
    	$info = DB::select($sql);
    	return $info;
    }

    public function insert_sql($id6d,$password){
    	$sql = 'insert into talk_worker (id6d, password) values ('.$id6d.','.$password.')';
    	$info = DB::insert($sql);
    	return $info;
    }

    public function update_sql($id,$password){
    	$sql = 'update talk_worker set password = '.$password.' where id = '.$id;
    	$info = DB::update($sql);
    	return $info;
    }

    public function delete_sql($id){
    	$sql = 'delete from talk_worker where id = '.$id;
    	$info = DB::delete($sql);
    	return $info;
    }
}
