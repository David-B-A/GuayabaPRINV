<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $salesPerMonth = Sale::selectRaw(
            'CONCAT(year(updated_at),"-",IF(month(updated_at)>=10,month(updated_at),CONCAT("0",month(updated_at)))) as date_str, sum(total) as sales'
        )
        ->where('payment_status','Pagado')
        ->groupBy('date_str')
        ->orderBy('date_str')
        ->get();
        return view('home',compact('salesPerMonth'));
    }
}
