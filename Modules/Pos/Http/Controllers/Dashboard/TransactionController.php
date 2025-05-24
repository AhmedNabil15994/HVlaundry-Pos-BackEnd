<?php

namespace Modules\Pos\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Transaction\Transformers\Dashboard\TransactionResource;
use Modules\Transaction\Repositories\Dashboard\TransactionRepository as Transaction;

class TransactionController extends Controller
{

    function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->transaction->QueryTable($request));

        $datatable['data'] = TransactionResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function subscriptions_datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->transaction->QuerySubscriptionsTable($request));

        $datatable['data'] = TransactionResource::collection($datatable['data']);

        return Response()->json($datatable);
    }
}
