<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    public function admin_login() {
        return view('auth.admin-login');
    }

    public function admin_login_validation(Request $req) {
        $req->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        try {
            //code...
            $checkUser = DB::table('admin')
                            ->where('email', $req->email)
                            ->orWhere('username', $req->email)
                            ->first();
            if(!$checkUser) {
                Alert::error('Email not registered');
                return back();
            }

            if(!Hash::check($req->password, $checkUser->password)) {
                Alert::error('Password Wrong');
                return back();
            }

            session([
                'admin_id' => $checkUser->id
            ]);

            return redirect(route('admin.index'));
        } catch (\Exception $e) {
            //throw $th;
            Alert::error($e->getMessage());
            return back();
        }
    }

    public function admin_logout() {
        try {
            //code...
            session()->flush();
            return redirect(route('auth.admin.login'));
        } catch (\Exception $e) {
            //throw $th;
            Alert::error($e->getMessage());
            return redirect(route('auth.admin.login'));
        }
    }

    public function executive_login() {
        return view('auth.executive-login');
    }

    public function executive_login_validation(Request $req) {
        $req->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        try {
            //code...
            $checkUser = DB::table('executive')
                            ->where('email', $req->email)
                            ->orWhere('username', $req->email)
                            ->first();
            if(!$checkUser) {
                Alert::error('Email not registered');
                return back();
            }

            if(!Hash::check($req->password, $checkUser->password)) {
                Alert::error('Password Wrong');
                return back();
            }

            session([
                'executive_id' => $checkUser->id
            ]);

            return redirect(route('admin.index'));
        } catch (\Exception $e) {
            //throw $th;
            Alert::error($e->getMessage());
            return back();
        }
    }

    public function executive_logout() {
        try {
            //code...
            session()->flush();
            return redirect(route('auth.executive.login'));
        } catch (\Exception $e) {
            //throw $th;
            Alert::error($e->getMessage());
            return redirect(route('auth.admin.login'));
        }
    }
}
