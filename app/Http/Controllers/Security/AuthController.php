<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Security\AuthService;

class AuthController extends Controller
{
    private AuthService $service;

    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    public function clearUserSession()
    {
        session()->forget([
            'logged_in',
            'user_id',
            'user_access'
        ]);
        return response('')->header('Content-Type', 'text/plain');
    }

    public function validateLogin(Request $request)
    {
        return $this->service->ValidateLogin($request->user, $request->pass);
    }

    public function authenticateUser(Request $request)
    {
        $page = $request->input('page');
        $session = $request->session();
        $access = json_decode($session->get('user_access')) ?? [];
        $clientAccess = $this->service->GetClientAccess($access);

        if (!$session->has('logged_in')) {
            return [
                'status' => 'Login'
            ];
        } elseif (!in_array($page, $clientAccess)) {
            return [
                'status' => 'Restricted'
            ];
        } else {
            return [
                'status' => 'Granted',
                'isValidatedNow' => true,
                'access' => $clientAccess
            ];
        }
    }
}
