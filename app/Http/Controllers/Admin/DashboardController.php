<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionDetail;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{
    public function index()
    {
        if(request()->ajax())
        {
            $query = TransactionDetail::with(['transaction', 'product.galleries'])
                                        ->whereHas('product', fn($query) => $query->where('users_id', auth()->user()->id))
                                        ->whereHas('transaction', fn($query) => $query->where('users_id', '!=', auth()->user()->id)->where('payment_status', 'SUCCESS')->where('transaction_status', '!=', 'SUCCESS'))->get()->unique('transactions_id');
            return DataTables::of($query)
                ->addColumn('action', function($item) {
                    return '
                        <div class="btn-group">
                            <a href="'. route('admin-transactions-sell-detail', $item->transaction->id) .'" class="btn btn-primary border-0 mr-1"> > </a>
                        </div>
                    ';
                })
                ->editColumn('image', function($item) {
                    if($item->product->galleries->count()) {
                        return '<img src="'. Storage::url($item->product->galleries->first()->photos) .'" style="max-height: 40px;"/>';
                    }
                })
                ->editColumn('product_name', function($item) {
                    return $item->product->name;
                })
                ->editColumn('buyer', function($item) {
                    return $item->transaction->user->name;
                })
                ->editColumn('total_products', function($item) {
                    $total = TransactionDetail::where('transactions_id', $item->transactions_id)->get()->count();
                    return $total;
                })
                ->editColumn('total_amount', function($item) {
                    return 'Rp. '. number_format($item->transaction->total_price) .'';
                })
                ->editColumn('created_at', function($item) {
                    return $item->created_at->format('d-M-Y') ;
                })
                ->editColumn('awb', function($item) {
                    return $item->transaction->awb;
                })
                ->editColumn('status', function($item) {
                    if($item->transaction->transaction_status == 'PENDING') {
                        $color = 'danger';
                    }
                    if($item->transaction->transaction_status == 'SHIPPING') {
                        $color = 'primary';
                    }
                    if($item->transaction->transaction_status == 'SUCCESS') {
                        $color = 'success';
                    }
                    return '
                        <div class="btn-group">
                            <span class="btn btn-'. $color .' border-0 mr-1"> '. $item->transaction->transaction_status .' </span>
                        </div>
                    ';
                })
                ->rawColumns(['action', 'image', 'total_products', 'product_name', 'buyer', 'total_amount', 'awb', 'status', 'created_at'])
                ->make();
        }
        
        $trx= TransactionDetail::whereHas('product', fn($query) => $query
                                    ->where('users_id', auth()->user()->id));
        $data['sell_products'] = $trx->get()->count();
        $trx_get = $trx->get();
        $revenue = 0;
        foreach ($trx_get as $item) {
            $revenue += $item->qty * $item->price - ($item->qty * $item->price * 2 / 100); // get the total with tax deduction
        }
        $data['revenue'] = $revenue;
        $data['commition_profit'] = Transaction::all()->sum('service_fee');
        $data['transaction'] = Transaction::where('users_id', auth()->user()->id)->sum('total_price');
        $data['user'] = User::findOrFail(auth()->user()->id);
        $data['belum_proses'] = $trx->whereHas('transaction', fn($query) => $query->where('transaction_status', 'PENDING'))->get()->unique('transactions_id')->count();
        $data['shipping'] = TransactionDetail::whereHas('product', fn($query) => $query
                                    ->where('users_id', auth()->user()->id))
                                    ->whereHas('transaction', fn($query) => $query->where('transaction_status', 'SHIPPING'))
                                    ->get()->unique('transactions_id')->count();
        return view('pages.admin.dashboard', $data);
    }

    public function settings()
    {
        $data['user'] = User::with('category')->findOrFail(auth()->user()->id);
        $data['categories'] = Category::all();
        return view('pages.admin.settings.settings', $data);
    }
    public function updateSettings(Request $request)
    {
        $data = $request->all();
        $user = User::findOrFail(auth()->user()->id);
        $user->update($data);
        
        return redirect()->route('admin-settings');
    }
    public function account()
    {
        $data['user'] = User::findOrFail(auth()->user()->id);
        return view('pages.admin.settings.account', $data);
    }
    public function updateAccount(Request $request)
    {
        $data = $request->all();
        $user = User::findOrFail(auth()->user()->id);
        $user->update($data);
        return redirect()->route('admin-account');
    }
}