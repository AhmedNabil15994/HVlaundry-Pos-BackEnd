<?php

namespace Modules\Coupon\Repositories\Dashboard;

use Illuminate\Support\Facades\DB;
use Modules\Coupon\Entities\Coupon;
use Modules\Coupon\Entities\RechargeCoupon;

class RechargeCouponRepository
{
    protected $coupon;

    public function __construct(RechargeCoupon $coupon)
    {
        $this->coupon = $coupon;
    }

    public function findById($id)
    {
        $coupon = $this->coupon->with( /* 'vendors', */'users',)->withDeleted()->find($id);
        return $coupon;
    }

    /**
     * @throws \Exception
     */
    public function create($request)
    {

        DB::beginTransaction();

        try {
            $data = [
                'code' => $request->code != null ? $request->code : str_random(5),
                'balance' => $request->balance,
                // 'max_discount_percentage_value' => $request->max_discount_percentage_value ?? null,
                'max_users' => $request->max_users,
                'user_max_uses' => $request->user_max_uses,
                'start_at' => $request->start_at,
                'expired_at' => $request->expired_at,
                'custom_type' => $request->custom_type,
                'status' => $request->status ? 1 : 0,
                'flag' => $request->coupon_flag ?? null,
                "title" => $request->title,
                "user_type" => $request->user_type ?? ['user'],
                'free_delivery' => $request->free_delivery ? 1 : 0,
                'users_count' => $request->users_count,
            ];

            $coupon = $this->coupon->create($data);

            if ($request['user_ids']) {
                $this->usersOfCouponSync($coupon, $request);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function update($request, $id)
    {
        DB::beginTransaction();

        $coupon = $this->findById($id);
        $restore = $request->restore ? $this->restoreSoftDelete($coupon) : null;

        try {
            $data = [
                'code' => $request->code,
                'balance' => $request->balance,
                // 'max_discount_percentage_value' => $request->max_discount_percentage_value ?? null,
                'max_users' => $request->max_users,
                'user_max_uses' => $request->user_max_uses,
                'start_at' => $request->start_at,
                'expired_at' => $request->expired_at,
                'custom_type' => $request->custom_type,
                'status' => $request->status ? 1 : 0,
                'flag' => $request->coupon_flag ?? null,
                "title" => $request->title,
                "user_type" => $request->user_type ?? ['user'],
                'free_delivery' => $request->free_delivery ? 1 : 0,
                'users_count' => $request->users_count,
            ];

            $coupon->update($data);

            $this->usersOfCouponSync($coupon, $request);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function restoreSoftDelete($model)
    {
        $model->restore();
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {

            $model = $this->findById($id);

            if ($model->trashed()):
                $model->forceDelete();
            else:
                $model->delete();
            endif;

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function deleteSelected($request)
    {
        DB::beginTransaction();

        try {

            foreach ($request['ids'] as $id) {
                $model = $this->delete($id);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function vendorsOfCouponSync($model, $request)
    {
        $model->vendors()->sync($request['vendor_ids']);
        return true;

        /*foreach ($request['vendor_ids'] as $key => $value) {
    $model->vendors()->updateOrCreate([
    'vendor_id' => $value,
    ]);
    }
    return true;*/
    }

    public function usersOfCouponSync($model, $request)
    {
        $model->users()->sync($request['user_ids']);
        return true;

        /*foreach ($request['user_ids'] as $key => $value) {
    $model->users()->updateOrCreate([
    'user_id' => $value,
    ]);
    }
    return true;*/
    }

    public function statesOfCouponSync($model, $states)
    {
        $model->states()->sync($states);
        return true;
    }

    public function categoriesOfCouponSync($model, $request)
    {
        $model->categories()->sync($request['category_ids']);
        return true;

        /*foreach ($request['category_ids'] as $key => $value) {
    $model->categories()->updateOrCreate([
    'category_id' => $value,
    ]);
    }
    return true;*/
    }

    public function ipackagesOfCouponSync($model, $request)
    {
        foreach ($request['ipackage_ids'] as $key => $value) {
            $model->ipackages()->updateOrCreate([
                'ipackage_id' => $value,
            ]);
        }
        return true;
    }

    public function productsOfCouponSync($model, $request)
    {
        $model->products()->sync($request['product_ids']);
        return true;

        /*foreach ($request['product_ids'] as $key => $value) {
    $model->products()->updateOrCreate([
    'product_id' => $value,
    ]);
    }
    return true;*/
    }

    public function QueryTable($request)
    {
        $query = $this->coupon;

        $query = $this->filterDataTable($query, $request);
        return $query;
    }

    public function filterDataTable($query, $request)
    {
        // SEARCHING INPUT DATATABLE
        if ($request->input('search.value') != null) {

            $query = $query->where(function ($query) use ($request) {
                $query->where('id', 'like', '%' . $request->input('search.value') . '%');
            });
        }

        // FILTER
        if (isset($request['req']['from']) && $request['req']['from'] != '') {
            $query->whereDate('created_at', '>=', $request['req']['from']);
        }

        if (isset($request['req']['to']) && $request['req']['to'] != '') {
            $query->whereDate('created_at', '<=', $request['req']['to']);
        }

        if (isset($request['req']['deleted']) && $request['req']['deleted'] == 'only') {
            $query->onlyDeleted();
        }

        if (isset($request['req']['deleted']) && $request['req']['deleted'] == 'with') {
            $query->withDeleted();
        }

        if (isset($request['req']['status']) && $request['req']['status'] == '1') {
            $query->active();
        }

        if (isset($request['req']['status']) && $request['req']['status'] == '0') {
            $query->unactive();
        }

        return $query;
    }
}
