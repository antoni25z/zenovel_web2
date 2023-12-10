<?php

namespace App\Controllers;

use App\Models\AdministratorModel;

class Administrator extends BaseController
{
    public function index()
    {
        return view('login_screen');
    }

    public function changePasswordView()
    {
        $data['id'] = session()->get('id');
        return view('profile/change_password', $data);
    }

    public function login()
    {
        $username = $this->request->getPost('user_name');
        $password = $this->request->getPost('password');

        $admin = new AdministratorModel();
        $check = $admin->where(['username' => $username])->first();

        if (empty($username) || empty($password)) {
            session()->setFlashdata('error', "Input kosong");
            return redirect()->to('/');
        }  else {
            if ($check) {
                if ($check->status != 0) {
                    if (password_verify($password, $check->password)) {
                        session()->set([
                            'logged_in' => true,
                            'username' => $check->username,
                            'id' => $check->id_administrator
                        ]);
                        return redirect()->to('/');
                    } else {
                        session()->setFlashdata('error', 'Username and password wrong');
                        return redirect()->to('login');
                    }
                } else {
                    session()->setFlashdata('error', "User Admin Has been blocked");
                    return redirect()->to('login');
                }
            } else {
                session()->setFlashdata('error', "User Admin Not Found");
                return redirect()->to('login');
            }
        }
    }

    public function changePassword($id) {

        $password = $this->request->getVar('password');

        $admin = new AdministratorModel();

        $data = [
            'password' => sha1($password)
        ];

        $update = $admin->update($id, $data);

        if ($update) {
            session()->setFlashdata('success', 'Change Password Success');
            return redirect()->to('/');
        } else {
            session()->setFlashdata('error', 'Change Password Failed');
            return redirect()->to('admin/change_password/'. $id);
        }
    }

    public function logout() {
        session()->destroy();
        return redirect()->to('login');
    }
}