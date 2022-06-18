<?php
namespace App\Services\Security;

use App\Models\User;

class AuthService
{
    public function ValidateLogin(string $user, string $pass): array
    {
        $row = User::select([
            'id',
            'name',
            'password'
        ])->where('login_name', $user)->first();

        if (\is_null($row)) {
            return [
                'status' => false,
                'message' => 'User Name doesn\'t Exists!!!'
            ];
        } elseif (password_verify($pass, $row->password) === false) {
            return [
                'status' => false,
                'message' => 'Incorrect Password'
            ];
        } else {
            $access = $this->AddSession($row);
            return [
                'status' => true,
                'user' => $row->name,
                'access' => $this->GetClientAccess($access)
            ];
        }
    }

    private function AddSession(object $row): array
    {
        $access = json_decode($this->GetAccess($row->id));
        array_push($access, 'Dashboard');

        session()->put([
            'user_id' => $row->id,
            'user_access' => json_encode($access),
            'logged_in' => true
        ]);

        return $access;
    }

    private function GetAccess(int $id)
    {
        return User::find($id, [
            'access'
        ])->access;
    }

    public function GetClientAccess(array $userAccess): array
    {
        $allAccess = config('useraccess');
        $allAccess['Dashboard'] = 'Dashboard';
        return array_map(fn (string $val): string => array_search($val, $allAccess), $userAccess);
    }

    public function ChangePassword(string $password): void
    {
        User::where('id', \session('user_id'))->update([
            'Password' => \password_hash($password, \PASSWORD_BCRYPT)
        ]);
    }
}
