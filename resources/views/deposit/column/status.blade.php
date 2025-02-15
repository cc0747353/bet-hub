<div class="badge {{($row->status == 1) ? 'bg-success' : (($row->status == 2) ? 'bg-danger' : 'bg-warning') }}">{{\App\Models\DepositTransaction::PAYMENT_STATUS[$row->status]}}</div>
