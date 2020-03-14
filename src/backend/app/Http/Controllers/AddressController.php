<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Http\Validators\RequestValidators;
use App\Models\Address;
use App\Http\Helpers\ControllerHelper;
use App\Models\Student;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class AddressController extends Controller
{

    /**
     * Get the authenticated User
     *
     * @param Request $request
     * @return JsonResponse [json] user object
     */
    public function profile(Request $request)
    {
        if ($request->user()->addresses()->exists()) {
            return response()->json($request->user()->addresses);
        } else {
            return response()->json([
                'message' => $request->base_role . ' Address not yet created. Please contact Admin'],
                404);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return LengthAwarePaginator
     */
    public function index()
    {
        return QueryBuilder::for(Address::class)
            ->allowedFilters([AllowedFilter::exact('pin_code'),
                AllowedFilter::exact('city'),
                AllowedFilter::exact('district'),
                AllowedFilter::exact('state'),
                AllowedFilter::exact('country'),])
            ->allowedIncludes(['user', 'user.roles', 'user.updater'])
            ->paginate(30)
            ->appends(request()->query());
    }


    /**
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request, User $user)
    {

        $validator = RequestValidators::addressValidator(array_merge($request->all(), ['user_id' => $user->id]));

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //a user can have only one communication and one permanent address.

        $address_type = $validator->validated()['type'];


        if ($user->addresses()->where('type', $address_type)->exists()) {
            return response()->json([
                'message' => "User's " . $address_type . " address already exists",
            ], 400);
        }


        $address = Address::create(array_merge($validator->validated(), ['user_id' => $user->id]));

        return response()->json([
            'message' => "User's " . $address_type . " address created successfully!",
            'address' => $address,
            'user' => $user
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function show(User $user)
    {
        //
        if ($user->addresses()->exists()) {
            return response()->json($user->addresses);
        } else {
            return response()->json([
                'message' => $user->base_role . ' Address not yet created. Please contact Admin'],
                404);
        }
    }


    /**
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, User $user)
    {
        $perms = [
            Constants::PERMISSIONS['REGISTER_STAFF'],
            Constants::PERMISSIONS['REGISTER_STUDENT'],
            Constants::PERMISSIONS['REGISTER_PARENT'],
            Constants::PERMISSIONS['REGISTER_ADMIN'],
        ];

        if (ControllerHelper::userEditsOwnProfileOrHasPermission($request, $user, $perms)) {

            $validator = RequestValidators::addressUpdateValidator($request->except('user_id'));

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $address_type = $validator->validated()['type'];

            $address = $user->addresses()->where('type', $address_type)->first();

            if (!$address) {

                return $this->store($request, $user);
                //can also call store method here
//                return response()->json([
//                    'message' => $user->base_role . ' ' . $address_type . ' Address not yet created. Please contact Admin'],
//                    400);
            }

            $address->update($validator->validated());

            return response()->json([
                'message' => $user->login_id . " address updated successfully!",
                'address' => $address,
                'user' => $user->refresh(),
            ], 200);

        } else {
            return response()->json([
                'message' => $request->user()->login_id . ' does not have the permission to update other ' . $user->base_role . ' profile'
            ], 403);
        }

    }
}
