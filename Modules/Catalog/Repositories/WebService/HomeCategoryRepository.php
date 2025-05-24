<?php

namespace Modules\Catalog\Repositories\WebService;

use Modules\Catalog\Entities\Category as Model;
use Modules\Core\Traits\CoreTrait;

class HomeCategoryRepository
{
    use CoreTrait;

    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function find($id, $with = [])
    {
        return $this->model
            ->with($with)
            ->active()->where("id", $id)->first();
    }

    public function list($request)
    {
        $query = $this->model->active();

        $query = $query->whereHas('products', function ($query) use ($request) {
            $query->active();
        });

        $query = $query->orderBy('sort', 'asc');

        if ($request->response_type == 'paginated')
            $query = $query->paginate($request->count ?? 24);
        else {
            if (!empty($request->count))
                $query = $query->take($request->count);
            $query = $query->get();
        }

        return $query;
    }
}
