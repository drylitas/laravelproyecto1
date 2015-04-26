<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller {
    public function getOrm(){
        //$users = User::get();
        $users = User::select('id','first_name','last_name')
            ->with('profile')
            ->orderBy('id','ASC')
            ->take(20)
            ->get();
        dd($users->toArray());
    }

    public function getOrm1(){
        $users = User::select('id','first_name','last_name')
            ->with('profile')
            ->orderBy('id','ASC')
            ->take(20)
            ->get();
        dd($users);
    }

    public function getOrm2(){
        $users = User::where('first_name', '<>', 'Andres')->take(10)->get();

        foreach ($users as $user)
        {
            var_dump($user->first_name);
        }
        dd($users);
    }
    public function getOrmscope(){
        $users = User::ejemplo()->get();
        dd($users);
    }
	public function getIndex(){
        $users = \DB::table('users')
            ->select([
                'users.*',
                //'first_name',
                //'last_name',
                'user_profiles.id as profile_id',
                'user_profiles.twitter',
                'user_profiles.birthdate'
            ])
            ->where('first_name', '<>', 'Duilio')
            ->orderBy('id', 'ASC')
            ->leftjoin('user_profiles', 'users.id', '=', 'user_profiles.user_id')
            ->get();
        foreach ($users as $row) {
            $row->full_name = $row->first_name . ' ' . $row->last_name;
            $row->age = \Carbon\Carbon::parse($row->birthdate)->age;
        }

        dd($users);

        //return $users;
    }

}
