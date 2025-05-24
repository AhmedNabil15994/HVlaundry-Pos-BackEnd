<?php

namespace Modules\Pos\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Authorization\Repositories\Dashboard\RoleRepository as Role;
use Modules\Catalog\Traits\ShoppingCartTrait;
use Modules\Core\Traits\DataTable;
use Modules\Pos\Http\Requests\Dashboard\UserPOSRequest;
use Modules\User\Http\Requests\Dashboard\UserRequest;
use Modules\User\Repositories\Dashboard\AddressRepository as AddressRepo;
use Modules\User\Repositories\Dashboard\UserRepository as User;
use Modules\User\Transformers\Dashboard\UserResource;


class CustomerController extends Controller
{
    use ShoppingCartTrait;

    protected $role;
    protected $user;
    protected $address;

    public function __construct(User $user, Role $role, AddressRepo $address)
    {
        $this->role = $role;
        $this->user = $user;
        $this->address = $address;
    }

    public function index()
    {
        return view('pos::dashboard.customers.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->user->QueryTable($request));
        $datatable['data'] = UserResource::collection($datatable['data']);
        return Response()->json($datatable);
    }

    public function getAll(Request  $request)
    {
        $users = $this->user->QueryTable($request)->get();
        $selectOptions = $users->map(function ($user)  {
            return [
                'id'            => $user->id,
                'text'         => $user->mobile . " -- " . $user->name,
            ];
        });
        return response()->json($selectOptions);
    }

    public function getOne($id)
    {
        $user = $this->user->findById($id);
        if (!$user)
            return Response()->json([false, __('apps::dashboard.general.not_found')]);

        $oldToken = $this->getCartUserToken();
        if($oldToken != $id && count(getCartContent($id, true)) <= 0){
            $this->updateCartKey($oldToken,$id);
        }
        return Response()->json([true, new UserResource($user)]);
    }

    public function show($id)
    {
        $user = $this->user->findById($id, ['addresses','orders','orders.transactions','successOrders']);
        if (!$user) {
            abort(404);
        }

        return view('pos::dashboard.customers.show', compact('user'));
    }

    public function store(UserPOSRequest $request)
    {
        try {
            $create = $this->user->create($request);

            if ($create) {
                return Response()->json([true, __('apps::dashboard.general.message_create_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

}
