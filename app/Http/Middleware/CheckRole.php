<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        
        //$role la bien nhan tu route dinh nghia trong routes/web.php
        if(!$request->user()){//neu user chua ton tai, co nghia chua dang nhap truoc do
            //neu da dang nhap thanh cong, $request->user() chinh la du lieu user da dang nhap tuong ung voi du
            //lieu trong DB (dang su dung Eloquent User duoc dinh nghia tai app/Models/User.php
            return redirect("login");
        }
        else{

          echo ";;;;;;;;;;;;;;";
        }
        return $next($request);//truong hop dung quyen
    }
}
