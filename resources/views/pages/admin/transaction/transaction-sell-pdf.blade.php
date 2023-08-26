<!DOCTYPE html>
<html>
<head>
	<title>Membuat Laporan PDF Dengan DOMPDF Laravel</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link href="/style/main.css" rel="stylesheet" />
</head>
<body onload="window.print();">
	<style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
			align-items: center;
		}
	</style>
	<center>
		<h5>Membuat Laporan PDF Dengan DOMPDF Laravel</h4>
	</center>

	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<div class="table table-responsive">
			<table class="table-hover scroll-horizontal-vertical w-100" id="sellTable">
				<thead>
					<tr>
						<th>No</th>
						<th>Nama Pembeli</th>
						<th>Nama Produk</th>
						<th>Qty</th>
						{{-- <th>Service Fee</th> --}}
						<th>Kode Transaksi</th>
						<th>Resi</th>
						<th>Sub Total</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($details as $detail)	
						@foreach($transactions->where('transactions_id', $detail->transactions_id) as $trx)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>{{$trx->transaction->user->name}}</td>
								<td>{{$trx->product->name}}</td>
								<td>{{$trx->qty}}</td>
								{{-- <td>{{$trx->transaction->service_fee}}</td> --}}
								<td>{{$trx->transaction->code}}</td>
								<td>{{$trx->transaction->awb}}</td>
								<td>{{number_format($trx->qty * $trx->price)}}</td>
							</tr>
						@endforeach
						<tr>
							<td colspan="7" align="right">Total: {{ number_format($detail->transaction->total_price) }} - {{ number_format($detail->transaction->service_fee) }}(Service Fee)</td>
						</tr>
						<tr>
							<td colspan="7" align="right"> <span class="font-weight-bold">Revenue: Rp. {{ number_format($detail->transaction->total_price - $detail->transaction->service_fee) }}</span> </td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
				</div>
			</div>
		</div>
	</div>

	<script src="/vendor/jquery/jquery.min.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>