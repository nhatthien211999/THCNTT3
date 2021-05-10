<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function getData(Request $request){

      $days = $request->input('days');

      $range = \Carbon\Carbon::now()->subDays($days);
      
      $stats = Device::where('created_at', '>=', $range)
        ->groupBy('date')
        ->orderBy('date', 'DESC')
        ->get([
          \DB::raw('Date(created_at) as date'),
          \DB::raw('COUNT(*) as value')
        ])
        ->toJSON();
      
      return $stats;
    }
}
