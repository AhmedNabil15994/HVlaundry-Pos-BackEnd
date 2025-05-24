<?php

namespace Modules\Transaction\Repositories\Dashboard;

use Illuminate\Support\Facades\File;
use Modules\Transaction\Entities\BaqatTransaction;
use Modules\Transaction\Entities\Transaction;
use Hash;
use DB;

class TransactionRepository
{

    function __construct(Transaction $transaction,BaqatTransaction  $subscripion_transaction)
    {
        $this->transaction   = $transaction;
        $this->subscripion_transaction   = $subscripion_transaction;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $transactions = $this->transaction->orderBy($order, $sort)->get();
        return $transactions;
    }

    public function findById($id)
    {
        $transaction = $this->transaction->find($id);
        return $transaction;
    }

    public function QueryTable($request)
    {
        $query = $this->transaction->where(function($query) use($request){
                    $query->where('id'                 , 'like' , '%'. $request->input('search.value') .'%');
                 });

        if(isset($request->user_id) && !empty($request->user_id)){
            $query = $query->whereHas('order',function ($q) use ($request){
                $q->where('user_id', $request->user_id);
            });
        }

        $query = $this->filterDataTable($query,$request);

        return $query;
    }

    public function QuerySubscriptionsTable($request)
    {
        $query = $this->subscripion_transaction->where(function($query) use($request){
            $query->where('id'                 , 'like' , '%'. $request->input('search.value') .'%');
        });

        if(isset($request->user_id) && !empty($request->user_id)){
            $query = $query->whereHas('baqatSubscription',function ($q) use ($request){
                $q->where('user_id', $request->user_id);
            });
        }

        $query = $this->filterDataTable($query,$request);

        return $query;
    }

    public function filterDataTable($query,$request)
    {
        // Search Pages by Created Dates
        if (isset($request['req']['from']) && $request['req']['from'] != '')
            $query->whereDate('created_at'  , '>=' , $request['req']['from']);

        if (isset($request['req']['to']) && $request['req']['to'] != '')
            $query->whereDate('created_at'  , '<=' , $request['req']['to']);

        if (isset($request['req']['deleted']) &&  $request['req']['deleted'] == 'only')
            $query->onlyDeleted();

        if (isset($request['req']['deleted']) &&  $request['req']['deleted'] == 'with')
            $query;

        if (isset($request['req']['status']) &&  $request['req']['status'] == '1')
            $query->active();

        if (isset($request['req']['status']) &&  $request['req']['status'] == '0')
            $query->unactive();

        return $query;
    }

    public function restoreSoftDelete($model)
    {
        $this->transaction->restore();
    }

    public function delete($id)
    {
        \Illuminate\Support\Facades\DB::beginTransaction();

        try {

            $model = $this->findById($id);
            if ($model) {
                $model->delete();
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /*
     * Find all Objects By IDs & Delete it from DB
     */
    public function deleteSelected($request)
    {
        DB::beginTransaction();

        try {

            if (!empty($request['ids'])) {
                foreach ($request['ids'] as $id) {
                    $model = $this->delete($id);
                }
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

}
