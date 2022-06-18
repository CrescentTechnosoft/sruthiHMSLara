<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserMasterController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index(): \Illuminate\Database\Eloquent\Collection
    {
        return User::all(['id', 'name']);
    }

    private function isUserExists(string $user, string $login, int $id = null): bool
    {
        return User::where(function ($query) use ($user, $login) {
            $query->where('name', $user)->orWhere('login_name', $login);
        })
                        ->when(is_null($id) === false, function ($query) use ($id) {
                            $query->where('id', '!=', $id);
                        })
                        ->count() > 0;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function store(Request $request):array
    {
        $data = \json_decode($request->getContent());

        if ($this->isUserExists($data->user, $data->login)) {
            return [
                'status' => false,
                'message' => 'User / Login name already Taken!!!'
            ];
        } else {
            User::insert([
                'name' => $data->user,
                'login_name' => $data->login,
                'password' => password_hash($data->pass, \PASSWORD_BCRYPT),
                'access' => '[]'
            ]);
            return [
                'status' => true,
                'message' => 'User Added',
                'id' => User::max('id')
            ];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return User
     */
    public function show($id): User
    {
        return User::find($id, ['name as user', 'login_name as login']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return array
     */
    public function update(Request $request, $id): array
    {
        $data = json_decode($request->getContent());

        if ($this->isUserExists($data->user, $data->login, $id)) {
            return [
                'status' => false,
                'message' => 'User / Login name already Taken!!!'
            ];
        } else {
            $update_data = [
                'name' => $data->user,
                'login_name' => $data->login
            ];
            if ($data->pass !== '') {
                $update_data['password'] = password_hash($data->pass, \PASSWORD_BCRYPT);
            }

            User::where('id', $id)
                    ->update($update_data);
            return [
                'status' => true,
                'message' => 'User Details Updated!!!'
            ];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): \Illuminate\Http\Response
    {
        User::where('id', $id)->delete();
        return response('User Details Deleted')->header('Content-Type', 'text/plain');
    }
}
