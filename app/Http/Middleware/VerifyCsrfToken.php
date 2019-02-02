<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;    //true:是将CSRF默认添加到请求头, false:不将CSRF添加到请求头

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //以下地址过来的请求不用验证,比如:
        //www.baidu.com,
        //www.taobao.com
    ];

    /**
     * CSRF的验证一些处理
     */
    // public function handle($request,Closure $next){
    //     //使用CSRF
    //     return parent::handle($request,$next);
    //     // 不使用CSRF
    //     // return $next($request);
    // }
}
