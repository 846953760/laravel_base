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

    //使用查询构造器操作
    public function query_builder_select(){
        // $sql = DB::table('talk_worker')->get();
        // $sql = DB::table('talk_worker')->first();
        // $sql = DB::table('talk_worker')->where('id','>',16)->get();
        $sql = DB::table('talk_worker')
                    ->where('id','>',5)
                    ->where('id','<',20)
                    ->where('password','like','%abc%')
                    ->orderBy('id','desc')
                    ->offset(1)
                    ->limit(5)
                    ->select('id','id6d','password')
                    ->get();
        // $sql = DB::table('talk_worker')->count();
        // $sql = DB::table('talk_worker')->max('id6d');
        // $sql = DB::table('talk_worker')->min('id');
        // $sql = DB::table('talk_worker')->avg('id6d');
        // $sql = DB::table('talk_worker')->sum('id6d');
        return dd($sql);
    }

    public function query_builder_insert($id6d,$password){
        // $sql = DB::table('talk_worker')->insert(['id6d'=>$id6d,'password'=>$password]);
        // $sql = DB::table('talk_worker')->insertGetId(['id6d'=>$id6d,'password'=>$password]);
        $sql = DB::table('talk_worker')->insert([['id6d'=>$id6d,'password'=>$password],['id6d'=>$id6d,'password'=>'1111']]);
        return dd($sql);
    }

    public function query_builder_update($id,$password){
        $sql = DB::table('talk_worker')->where('id','=',$id)->update(['password'=>$password]);
        // $sql = DB::table('talk_worker')->where('id','=','19')->increment('id6d');
        // $sql = DB::table('talk_worker')->where('id','=','20')->decrement('id6d');
        // $sql = DB::table('talk_worker')->where('id','>','21')->increment('id6d',100);
        // $sql = DB::table('talk_worker')->where('id','<10','10')->decrement('id6d',100);
        // $sql = DB::table('talk_worker')->where('id','=','22')->increment('id6d','10',['password'=>'abcdefg']);
        return dd($sql);
    }

    public function query_builder_delete($id){
        $sql = DB::table('talk_worker')->where('id','=',$id)->delete();
        // 清空表,不返回任何标识
        // $sql = DB::table('talk_worker')->truncate();
        return dd($sql);
    }

    //使用ORM操作
    //指定表名,如果不指定的话,表名为class名的复数形式
    protected $table = 'talk_worker';

    //设置表的主键字段名,如果不指定的话,主键字段名默认为id字段
    protected $primaryKey = 'id';

    //设置表的主键是自增,如果不设置的话,默认为true(自增),不自增或非数值类型的主键字段,需将此值设置为false
    public $incrementing = true;

    //时间戳字段,默认为true,认为表里有created_at和updated_at字段.如果表里没有这两字段,设置为false
    public $timestamps = false;

    //自定义created_at字段名和updated_at字段名
    const CREATED_AT = "create_time";
    const UPDATED_AT = "update_time";

    //自定义时间戳保存在数据库里的格式,值为date()的第一个参数,比如U代表时间戳,Y代表2017年
    protected $dateFormat = 'U';

    //自定义数据库连接,默认使用的config/database.php中的mysql.如要连接mysql2,在database.php复制mysql整段配置,改名为mysql2,注意配置值从.env文件中取的
    // protected $connection = 'mysql2';
}
