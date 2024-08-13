<?php

namespace Modules\User\app\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\User\Models\User;
use Modules\User\app\Repositories\Interfaces\UserRepositoryInterface;



class UserRepository implements UserRepositoryInterface
{
    
    public function create($userInfo)
    {
        return User::create($userInfo); 
    }

    public function get($info, $identifier)
    {
        return User::where($identifier , $info)->first();
    }

    public function listWithRole($role)
    {
        return User::role($role)->get();
    }

    public function login($login_info, $login_type){

        return User::where($login_type,$login_info)->first();
    }

    public function update($user, $data) {
        $user->update($data);
        return $user;
    }

    public function listWithSales() {
        $users = User::select('users.id','users.first_name', 'users.last_name', 'roles.name as role', DB::raw('SUM(reservations.total_price) as total_reservation_price'))
        ->leftJoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
        ->leftJoin('roles', 'model_has_roles.role_id', '=', 'roles.id')
        ->leftjoin('assets', 'users.id', '=', 'assets.user_id')
        ->leftJoin('service_asset', 'assets.id', '=', 'service_asset.asset_id')
        ->leftJoin('reservations', 'service_asset.id', '=', 'reservations.event_id')
        ->where('roles.id','!=', 1)
        ->where('roles.id', '!=', 2)
        ->groupBy('users.id','users.first_name','users.last_name', 'roles.name')
        ->get();
        return $users;
    }

    public function filterForReservation($filters)
    {

        $query = User::query();

    foreach ($filters as $filter) {
        switch ($filter['fieldName']) {
            case 'name':
                $query->where('first_name', 'LIKE', '%' . $filter['value1'] . '%')
                ->orWhere('last_name', 'LIKE', '%' . $filter['value1'] . '%');
                break;
            case 'role':
                $query->whereHas('roles', function ($query) use ($filter) {
                    $query->where('name', $filter['value1']);
                });
                break;

            case 'sales':
                $query->select('users.id','users.first_name', 'users.last_name', 'roles.name as role', DB::raw('SUM(reservations.total_price) as total_reservation_price'))
                        ->Join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                        ->Join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                      ->join('assets', 'users.id', '=', 'assets.user_id')
                      ->join('service_asset', 'assets.id', '=', 'service_asset.asset_id')
                      ->join('reservations', 'service_asset.id', '=', 'reservations.event_id')
                      ->groupBy('users.id','users.first_name','users.last_name', 'roles.name')
                      ->havingRaw($this->getHavingCondition($filter));
                break;

            case 'start_date':
                $query->whereHas('contracts', function ($query) use ($filter) {
                    $query->where('start_date', $filter['operation'], $filter['value1']);
                });
                break;
            case 'end_date':
                $query->whereHas('contracts', function ($query) use ($filter) {
                    $query->where('end_date', $filter['operation'], $filter['value1']);
                });
                break;
        }
    }

    return $query->get();

    }

    protected function getHavingCondition(array $filter)
{
    $condition = '';

    switch ($filter['operation']) {
        case '>':
        case '<':
        case '=':
        case '!=':
            $condition = "total_reservation_price {$filter['operation']} {$filter['value1']}";
            break;

        case '<>':
            $condition = "total_reservation_price BETWEEN {$filter['value1']} AND {$filter['value2']}";
            break;

        case '><':
            $condition = "total_reservation_price NOT BETWEEN {$filter['value1']} AND {$filter['value2']}";
            break;
    }

    return $condition;
}

    
}