<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $customer = User::count();
        $revenue = Transaction::sum('total_price');
        $transaction = Transaction::count();
        
        $data['customer'] = $customer;
        $data['revenue'] = $revenue;
        $data['transaction'] = $transaction;
        
        return view('pages.admin.dashboard', $data);
    }
}