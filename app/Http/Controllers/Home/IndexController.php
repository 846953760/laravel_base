<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        echo "Home/Index/Index<br>";
        $msg = '你好';
        echo get_zh_len($msg);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        echo "Home/Index/create<br>";
        $user = new User;
        $id6d = $request->input('id6d');
        $password = $request->input('password');
        $info = $user->insert_sql($id6d,$password);
        echo $info;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // echo $request->input('id');          //获取指定输入值
        // echo $request->input('id','1');     //获取请求参数id字段，默认为1
        // echo $request->input('products.*.name');     //如果传输表单数据中包含数组形式的数据，可以使用点语法来获取数组
        // echo $request->query('id');          //只从查询字符串中获取输入数据
        // echo $request->query('id','2');     //从查询字符串中获取请求参数id字段，默认为2
        // echo $request->query();              //以关联数组的形式检索所有查询字符串
        // echo $request->ids;                  //通过动态属性获取输入
        // echo $request->input('user.name');   //请求头Content-Type为application/json，获取json数据
        // echo $request->path();               //获取请求路径，输出为home/index/store
        // if($request->is('home/*')){
        //     echo '请求路径是从home进来的';
        // }else{
        //     echo '请求路径为'.$request->path();
        // }
        // echo $request->url();                //获取传入请求的完整url，不带get参数
        // echo $request->fullUrl();               //获取传入请求的完整url，带get参数
        // echo $request->method();                //获取请求方式，GET/POST
        // if($request->isMethod('post')){
        //     echo '请求是以post形式请求的';
        // }else if($request->isMethod('get')){
        //     echo '请求是以get形式请求的';
        // }else{
        //     echo '请求是以除post和get之外的形式请求的';
        // }
        // echo $request->all();                    //以数组形式获取所有输入数据
        // echo $request->ip();                     //获取请求的ip
        // echo $request->getPort();                //获取端口
        // echo $request->has('name');              //检查请求参数是否含有name字段
        // echo $request->only(['id','ids']);       //提取部分参数
        // echo $request->except(['id','ids']);     //剔除部分参数
        // echo $request->header('Connection');     //获取请求头的Connection字段
        // echo $request->hasFile('cover');         //检查是否有文件上传
        // echo $request->file('file');             //提取上传的文件
        // echo $request->file('file')->isValid();  //验证上传文件是否有效
        // echo $request->photo->path();            //访问文件的完整路径
        // echo $request->photo->extension();       //文件的扩展名
        // echo $request->photo->store('images');         //接受相对于文件系统配置的存储文件根目录的路径,不能包含文件名,系统会自动生成唯一的ID作为文件名,返回路径
        // echo $request->photo->storeAs('images','filename.jpg');      //自定义文件名
        // echo $request->cookie();                 //获取cookie
        // $cookie = cookie('name','value',$minutes);   //设置cookie,第一个参数为cookie名,第二个参数为cookie值,第三个参数为有效期(分钟)
        // return response('Hello world')->cookie($cookie);     //cookie被附加到响应实例,发送回客户端
        // if($request->filled('name')){
        //     echo '请求值中有name字段，且不为空';
        // }else{
        //     echo '请求值中没有name字段，或为空';
        // }
        // $request->flash();                       //将当前输入的数据存入session
        // $request->flashOnly(['username','email']);   //将请求数据的一部分闪存到session
        // $request->flashExcept('password')            //将请求数据除密码外闪存到session
        // echo $request->old('username');              //获取上一次请求中闪存的输入
        // $response->withCookie(cookie('cookie_name','cookie_value',3));       //新增cookie,第一个参数为cookie名,第二个参数为cookie值,第三个参数为有效期(分钟)
        // $response->withCookie(cookie()->forever('cookie_name','cookie_value'));      //设置cookie长期有效
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        echo "Home/Index/show<br>";
        $user = new User;
        $info = $user->select_sql($id);
        dump($info);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        echo "Home/Index/update<br>";
        $password = $request->input('password');
        $user = new User;
        $info = $user->update_sql($id,$password);
        echo $info;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        echo "Home/Index/destroy<br>";
        $user = new User;
        $info = $user->delete_sql($id);
        echo $info;
    }
}
