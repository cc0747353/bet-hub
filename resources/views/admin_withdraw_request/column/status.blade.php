<div class="badge {{($row->status == 1) ? 'bg-success' : (($row->status == 2) ? 'bg-warning' : 'bg-danger') }}" >{{\App\Models\WithdrawRequests::PAYMENT_STATUS[$row->status]}}</div>
