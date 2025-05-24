<?php

namespace Modules\Transaction\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Transaction\Repositories\Dashboard\TransactionRepository;
use Modules\Transaction\Transformers\Dashboard\TransactionResource;
use Modules\Transaction\Repositories\Dashboard\TransactionRepository as Transaction;

class TransactionController extends Controller
{

    function __construct(Transaction $transaction,TransactionRepository $transactionRepository)
    {
        $this->transaction = $transaction;
        $this->transactionRepository = $transactionRepository;
    }

    public function index()
    {
        return view('transaction::dashboard.transactions.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->transaction->QueryTable($request));

        $datatable['data'] = TransactionResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function show($id)
    {
        abort(404);
        return view('transaction::dashboard.transactions.show');
    }

    public function destroy($id)
    {
        try {
            $delete = $this->transactionRepository->delete($id);

            if ($delete) {
                return Response()->json([true, __('apps::dashboard.general.message_delete_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function deletes(Request $request)
    {
        try {
            if (empty($request['ids']))
                return Response()->json([false, __('apps::dashboard.general.select_at_least_one_item')]);

            $deleteSelected = $this->transactionRepository->deleteSelected($request);
            if ($deleteSelected) {
                return Response()->json([true, __('apps::dashboard.general.message_delete_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
