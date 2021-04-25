<?php

namespace App\Http\Controllers;

use Facade\FlareClient\View;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class FirebaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function view()
    {
        return View('info');
    }
 
    public function switch(Request $request)
    {
        $location = $request->input('location');
        $route = $request->input('route');
        $factory = (new Factory())
        ->withDatabaseUri('https://demohung-79e75-default-rtdb.firebaseio.com');    
        $database   =   $factory->createDatabase(); 
        if($request->input('status')=='OFF'){
            $status='ON';
        }else{
            $status='OFF';
        }
        $id=auth()->user()->id;
        $updates = [
            "$id/$location/$route/status"=> $status,
        ];//tạo mảng với key là route để lưu vào firebase nếu chưa có thì nó sẽ thêm mới   
        $database->getReference('') // this is the root reference
        ->update($updates);
        return response()->json(array('route'=>$route,'location'=>$location,'status'=>$status,'id'=>$id), 200);
    }
    
    public function changeSchedule(Request $request)
    {
        $location=$request->input('location');
        $route=$request->input('route');
        $factory = (new Factory())
        ->withDatabaseUri('https://demohung-79e75-default-rtdb.firebaseio.com');    
        $database   =   $factory->createDatabase();
        $id=auth()->user()->id;
        $updates = [
            "$id/$location/$route/TimeOn"=> $request->input('timeon'),
            "$id/$location/$route/TimeOff"=> $request->input('timeoff'),
        ];//tạo mảng với key là route để lưu vào firebase nếu chưa có thì nó sẽ thêm mới   
        $database->getReference('') // this is the root reference
        ->update($updates);
        return response()->json(array('route'=>$route,'location'=>$location,'schedule'=>$request->input('timeon')), 200);
    }
    public function broken(Request $request)
    {
        $location = $request->input('location');
        $route = $request->input('route');
        $factory = (new Factory())
        ->withDatabaseUri('https://demohung-79e75-default-rtdb.firebaseio.com');    
        $database   =   $factory->createDatabase(); 
        if($request->input('status')== 'true'){
            $status='false';
        }else{
            $status= 'true';
        }
        $id=auth()->user()->id;
        $updates = [
            "$id/$location/$route/broken"=> $status,
        ];//tạo mảng với key là route để lưu vào firebase nếu chưa có thì nó sẽ thêm mới   
        $database->getReference('') // this is the root reference
        ->update($updates);
        return response()->json(array('route'=>$route,'location'=>$location,'status'=>$status,'id'=>$id), 200);
    }

}
