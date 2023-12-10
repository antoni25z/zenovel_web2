<?php

namespace App\Controllers;

use App\Models\AdministratorModel;
use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;
use Config\Services;

class UserManagement extends BaseController
{

    use ResponseTrait;
    public function allAdmin()
    {
        $admin = new AdministratorModel();
        $data['pagination'] = $admin->where('id_administrator !=', session()->get('id'))->orderBy('created', 'desc')->findAll();
        return view('user_management/admin_user/index', $data);
    }

    public function allUser()
    {
        $user = new UserModel();
        $data['data'] = $user->orderBy('created', 'desc')->findAll();
        return view('user_management/google_user/index', $data);
    }

    public function add_admin_view()
    {
        return view('user_management/admin_user/add_user');
    }

    public function add_admin()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $status = $this->request->getPost('status');

        $admin = new AdministratorModel();

        $validate = $this->validate(
            [
                'username' => 'required',
                'password' => 'required',
                'status' => 'required'
            ]
        );

        if (!$validate) {
            session()->setFlashdata('error', "Field not be empty");
            return redirect()->to('user_management/admin/add_user');
        } else {
            if ($status == 'Active') {
                $cStatus = 1;
            } else {
                $cStatus = 0;
            }

            $data = [
                'id_administrator' => uniqid(),
                'username' => $username,
                'password' => password_hash($password, PASSWORD_BCRYPT),
                'user_level' => 2,
                'status' => $cStatus
            ];
            $query = $admin->where('username', $username)->first();

            if ($query) {
                session()->setFlashdata('error', 'Username already exists');
                return redirect()->to('user_management/admin/add_user');
            } else {
                $add = $admin->insert($data);
                if ($add) {
                    session()->setFlashdata('success', 'User Created Successfully');
                    return redirect()->to("/");
                } else {
                    session()->setFlashdata('error', 'User Created Failed');
                    return redirect()->to('user_management/admin/add_user');
                }
            }
        }

    }

    public function changeAdminPassword() {

        $password = $this->request->getVar('password');
        $id = $this->request->getVar('id');

        $admin = new AdministratorModel();

        $data = [
          'password' => password_hash($password, PASSWORD_BCRYPT)
        ];

        $update = $admin->update($id, $data);

        if ($update) {


            $response = [
                'error' => false,
                'message' => 'Success',
                'token' => csrf_hash()
            ];
        } else {
            $response = [
                'error' => true,
                'message' => 'Failed'
            ];
        }
        return $this->response->setJSON($response);
    }

    public function blockUser() {

        $user = new UserModel();
        $id = $this->request->getVar('id');
        $data = [
            'status' => 0
        ];

        $update = $user->update($id, $data);

        if ($update) {
            $response = [
                'error' => false,
                'message' => 'block user success',
            ];
        } else {
            $response = [
                'error' => true,
                'message' => 'block user failed'
            ];
        }
        return $this->response->setJSON($response);
    }

    public function unblockUser() {

        $user = new UserModel();
        $id = $this->request->getVar('id');
        $data = [
            'status' => 1
        ];

        $update = $user->update($id, $data);

        if ($update) {
            $response = [
                'error' => false,
                'message' => 'unblock user success',
            ];
        } else {
            $response = [
                'error' => true,
                'message' => 'unblock user failed'
            ];
        }
        return $this->response->setJSON($response);
    }

    public function deleteUser() {

        $user = new UserModel();
        $id = $this->request->getVar('id');
        $update = $user->delete($id);

        if ($update) {
            $response = [
                'error' => false,
                'message' => 'delete user success',
            ];
        } else {
            $response = [
                'error' => true,
                'message' => 'delete user failed'
            ];
        }
        return $this->response->setJSON($response);
    }

    public function blockAdminUser() {

        $admin = new AdministratorModel();
        $id = $this->request->getVar('id');
        $data = [
            'status' => 0
        ];

        $update = $admin->update($id, $data);

        if ($update) {
            $response = [
                'error' => false,
                'message' => 'block user success',
            ];
        } else {
            $response = [
                'error' => true,
                'message' => 'block user failed'
            ];
        }
        return $this->response->setJSON($response);
    }

    public function unblockAdminUser() {

        $admin = new AdministratorModel();
        $id = $this->request->getVar('id');
        $data = [
            'status' => 1
        ];

        $update = $admin->update($id, $data);

        if ($update) {
            $response = [
                'error' => false,
                'message' => 'unblock user success',
            ];
        } else {
            $response = [
                'error' => true,
                'message' => 'unblock user failed'
            ];
        }
        return $this->response->setJSON($response);
    }

    public function deleteAdminUser() {

        $admin = new AdministratorModel();
        $id = $this->request->getVar('id');
        $update = $admin->delete($id);

        if ($update) {
            $response = [
                'error' => false,
                'message' => 'delete user success',
            ];
        } else {
            $response = [
                'error' => true,
                'message' => 'delete user failed'
            ];
        }
        return $this->response->setJSON($response);
    }
}