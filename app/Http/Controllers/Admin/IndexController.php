<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // session('time',date('Y-m-d H:i:s'));     //取session的time字段，指定一个默认值
        // session(['time'=>date('Y-m-d H:i:s')]);  //设置session的time字段
        // session(['time1'=>time()]);              //设置session的time1字段
        // session()->forget('time');               //清除session的time字段
        // session()->regenerate();                 //重置session的sessionID
        dump(session()->all());
        // echo url()->current();  //当前url
        // echo url()->full();
        // echo url()->previous();
        // return "Hello world";   //return 字符串
        // return array('a'=>1,'b'=>2,'c'=>3);     //return 数组，但是框架会自动转为json
        // return response('hello world', 200);        //自定义响应值和响应状态码
        // return response(array('a'=>1,'b'=>2,'c'=>3),200)->header('Content-Type','application/json');    //自定义响应值、响应状态码、响应类型
        
        //链式写法1，可以设置多值
        // return response(array('a'=>1,'b'=>2,'c'=>3),200)
        //             ->header('Content-Type','application/json')
        //             ->header('X-Header-One','Header value 1')
        //             ->header('X-Header-Two','Header value 2');
        //链式写法2，使用withHeaders数组
        // return response(array('a'=>1,'b'=>2,'c'=>3),200)
        //             ->withHeaders([
        //                 'Content-Type'=>'application/json',
        //                 'X-Header-One'=>'Header value 1',
        //                 'X-Header-Two'=>'Header value 2'
        //             ]);
        // return response('hello world', 200)->cookie('name','value',1);  //设置响应的cookie,该cookie被openssl_encrypt加密,如果不想被加密,可以去EncryptCookies.php添加该cookie的name
        // return redirect('/home/index/show/1');      //重定向到/home/index/show/1中，注意必须在route中配置/home/index/show/{id}
        // return redirect()->away('https://www.baidu.com');    //重定向到外部地址，得使用away
        // return response()->view('admin.index',array('a','b'),200)->header('Content-Type','text/plain');
        // return response()->json(array('a'=>1,'b'=>2,'c'=>3));
        // return response()->json(['name'=>'lisi','age'=>20])->withCallback($request->input('callback')); //创建jsonp响应
        // return response()->download(public_path().'\robots.txt','111.txt');     //下载文件，第一个参数为文件的绝对路径,第二个参数为下载时要显示的文件名,第三个参数可以设置header头
        return view('admin.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        echo "Admin/Index/store";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        echo $request->input('account').'<br>';
        echo $request->input('password').'<br>';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
