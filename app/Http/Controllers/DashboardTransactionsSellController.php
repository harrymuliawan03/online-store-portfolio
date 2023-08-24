<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransactionDetail;
use App\Models\Transaction;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class DashboardTransactionsSellController extends Controller
{
    public function index()
    {
        if(request()->ajax())
        {
            $query = TransactionDetail::with(['transaction', 'product'])
                                        ->whereHas('product', fn($query) => $query->where('users_id', auth()->user()->id))
                                        ->whereHas('transaction', fn($query) => $query->where('users_id', '!=', auth()->user()->id)->where('payment_status', 'SUCCESS'))->get()->unique('transactions_id');
            return DataTables::of($query)
                ->addColumn('action', function($item) {
                    return '
                        <div class="btn-group">
                            <a href="'. route('transactions-sell-detail', $item->transaction->id) .'" class="btn btn-primary border-0 mr-1"> > </a>
                        </div>
                    ';
                })
                ->editColumn('image', function($item) {
                    return $item->product->galleries->first()->photos ? '<img src="'. Storage::url($item->product->galleries->first()->photos) .'" style="max-height: 40px;"/>' : '';
                })
                ->editColumn('product_name', function($item) {
                    return $item->product->name;
                })
                ->editColumn('buyer', function($item) {
                    return $item->transaction->user->name;
                })
                ->editColumn('total_products', function($item) {
                    $total = TransactionDetail::where('transactions_id', $item->transactions_id)->get()->count();
                    return '<p class="text-center">'. $total .'</p>';
                })
                ->editColumn('total_amount', function($item) {
                    return $item->transaction->total_price;
                })
                ->editColumn('created_at', function($item) {
                    return $item->created_at->format('d-M-Y') ;
                })
                ->editColumn('code_trx', function($item) {
                    return $item->transaction->code ;
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
                ->rawColumns(['action', 'image', 'product_name', 'buyer', 'total_products', 'total_amount', 'awb', 'status', 'created_at','code_trx'])
                ->make();
        }
        return view('pages.dashboard-transactions-sell');
    }
    public function detail($id)
    {
        $data['sell'] = TransactionDetail::with(['transaction.user', 'product.galleries'])->where('transactions_id', $id)->firstOrFail();
        $data['details'] = TransactionDetail::with(['transaction', 'product.galleries'])
                                                ->whereHas('product', fn($query) => $query->where('users_id', auth()->user()->id))
                                                ->whereHas('transaction', fn($query) => $query->where('id', $id))->get();
        
        return view('pages.dashboard-transactions-details-sell', $data);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $item = Transaction::findOrFail($id);
        
        $item->update($data);
        
        return redirect()->route('transactions-sell');
    }
}