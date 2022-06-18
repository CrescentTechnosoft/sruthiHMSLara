<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserAccessController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::select(['id', 'name'])->get();
        $user_access = collect(json_decode(User::find($users->first()->id)->access));

        $all_access = collect(config('useraccess'));
        $access_keys = $all_access->keys();
        $all_access_conv = $access_keys->map(function ($map) {
            return [
        'access' => $map,
        'allowed' => false
            ];
        });

        $userAccess = $user_access->map(function ($map) use ($all_access) {
            return $all_access->search($map);
        });
        return ['users' => $users, 'access' => $all_access_conv, 'userAccess' => $userAccess];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user_access = collect(\json_decode(User::find($id)->access));
        $all_access = collect(config('useraccess'));

        return $user_access->map(function ($map) use ($all_access) {
            return $all_access->search($map);
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $given_access = collect(json_decode(file_get_contents('php://input')));
        $all_access = collect(config('useraccess'));

        $user_access = $given_access->map(function ($map) use ($all_access) {
            return $all_access->get($map);
        });

        User::where('id', $id)->update([
            'access' => $user_access
        ]);
        return response('User Access Updated!!!')->header('Content-Type', 'text/plain');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
