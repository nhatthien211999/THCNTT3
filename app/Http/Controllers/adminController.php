<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use PhpParser\Node\Expr\FuncCall;

class adminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function view(){
        return view("admin.home");
    }
    public function user(){

        $users = User::all();
        
        return View('admin.user',['users'=>$users]);
    }
    //làm thêm người dùng
    public function addHome(Request $request)//thêm user và location
    {
        
        $userHome=$request->input('idUser');//reqestid user
        $location=$request->input('location');//gắn request location
        $route=$request->input('route');//gắn request route
        $factory = (new Factory())
        ->withDatabaseUri('https://demohung-79e75-default-rtdb.firebaseio.com');    
        $database   =   $factory->createDatabase(); 
        $updates = [
            "$userHome/$location/$route/status"=> "OFF",
            "$userHome/$location/$route/TimeOn"=> "00:00:00",
            "$userHome/$location/$route/TimeOff"=> "00:00:00",

        ];//tạo mảng với key là route để lưu vào firebase nếu chưa có thì nó sẽ thêm mới   
        $database->getReference('') // this is the root reference
        ->update($updates);
    }
    public function lightsUser($id){
        return view("admin.infoLightUser",['idUser'=>$id]);
    }
  





}
