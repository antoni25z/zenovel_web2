<?php

namespace App\Controllers\api;

use App\Controllers\BaseController;
use App\Models\ReportModel;
use App\Models\SettingModel;
use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use Exception;

class User extends BaseController
{
    use ResponseTrait;

    public function addGoogleUser()
    {
        $user = new UserModel();

        $user_id = $this->request->getPost('user_id');
        $email = $this->request->getPost('email');
        $full_name = $this->request->getPost('full_name');
        $user_image = $this->request->getPost('user_image');
        $token_fcm = $this->request->getPost('token_fcm');

        $rules = [
            "user_id" => "required",
            "email" => "required|valid_email",
            "full_name" => "required",
            "user_image" => "required",
            "token_fcm" => "required",
        ];

        $messages = [
            "user_id" => [
                "required" => "User ID is required"
            ],
            "email" => [
                "required" => "Email is required",
                "valid_email" => "Email address is not in format",
            ],
            "full_name" => [
                "required" => "Full name is required"
            ],
            "user_image" => [
                "required" => "User image is required"
            ],
            "token_fcm" => [
                "required" => "Token Firebase Messaging is required"
            ],
        ];

        $query = $user->find($user_id);

        helper('jwt');

        if (!$this->validate($rules, $messages)) {
            $response = [
                'error' => true,
                'message' => $this->validator->getErrors()
            ];
        } else {
            if (!$query) {
                $data = [
                    'id' => $user_id,
                    'email' => $email,
                    'full_name' => $full_name,
                    'user_image' => $user_image,
                    'token_fcm' => $token_fcm,
                    'status' => 1
                ];

                $add = $user->insert($data);

                if ($add) {
                    $response = [
                        'error' => [
                            'status_code' => ResponseInterface::HTTP_OK,
                            'block' => false,
                            'error' => false,
                            'delete' => false
                        ],
                        'message' => 'Success',
                        'result' => [
                            'access_token' => getSignedJWTForUser($user_id)
                        ]
                    ];
                } else {
                    $response = [
                        'error' => [
                            'status_code' => ResponseInterface::HTTP_OK,
                            'block' => false,
                            'error' => true,
                            'delete' => false
                        ],
                        'message' => 'Failure'
                    ];
                }

            } else {
                if ($query->status == 0) {
                    $response = [
                        'error' => [
                            'status_code' => ResponseInterface::HTTP_OK,
                            'block' => true,
                            'error' => false,
                            'delete' => false
                        ],
                        'message' => 'User has been blocked',
                    ];
                } else {
                    $response = [
                        'error' => [
                            'status_code' => ResponseInterface::HTTP_OK,
                            'block' => false,
                            'error' => false,
                            'delete' => false
                        ],
                        'message' => 'Success',
                        'result' => [
                            'access_token' => getSignedJWTForUser($user_id)
                        ]
                    ];
                }
            }
        }

        return $this->respond($response);
    }

    public function user_profile()
    {

        $authenticationHeader = $this->request->getServer('HTTP_AUTHORIZATION');

        try {

            helper('jwt');
            $encodedToken = getJWTFromRequest($authenticationHeader);
            $us = validateJWTFromRequest($encodedToken);

            if ($us->status == 0) {
                $response = [
                    'error' => [
                        'status_code' => ResponseInterface::HTTP_UNAUTHORIZED,
                        'block' => true,
                        'error' => false,
                        'delete' => false
                    ],
                    'message' => 'User has been blocked',
                ];
                return Services::response()
                    ->setJSON($response)
                    ->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
            } else {
                $user = new UserModel();

                $data = $user->find($us->id);

                $response = [
                    'error' => [
                        'status_code' => ResponseInterface::HTTP_OK,
                        'block' => false,
                        'error' => false,
                        'delete' => false
                    ],
                    'message' => 'Success',
                    'result' => $data
                ];
                return $this->response->setJSON($response);
            }
        } catch (Exception $e) {

            $response = [
                'error' => [
                    'status_code' => ResponseInterface::HTTP_UNAUTHORIZED,
                    'block' => false,
                    'error' => true,
                    'delete' => false
                ],
                'message' => $e->getMessage()
            ];

            return Services::response()
                ->setJSON($response)
                ->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);

        }
    }

    public function update_image()
    {

        $authenticationHeader = $this->request->getServer('HTTP_AUTHORIZATION');

        try {

            helper('jwt');
            $encodedToken = getJWTFromRequest($authenticationHeader);
            $us = validateJWTFromRequest($encodedToken);

            if ($us->status == 0) {
                $response = [
                    'error' => [
                        'status_code' => ResponseInterface::HTTP_UNAUTHORIZED,
                        'block' => true,
                        'error' => false,
                        'delete' => false
                    ],
                    'message' => 'User has been blocked',
                ];
                return Services::response()
                    ->setJSON($response)
                    ->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
            } else {
                $user = new UserModel();
                $userImage = $this->request->getFile('user_image');

                $fileName = $us->id . '.png';
                $old = $user->find($us->id);
                if (file_exists('image/user/' . $old->user_image)) {
                    unlink('image/user/' . $old->user_image);
                }

                $userImage->move('image/user', $fileName);

                $data = [
                    'user_image' => $fileName
                ];

                $update = $user->update($us->id, $data);

                if ($update) {
                    $response = [
                        'error' => [
                            'status_code' => ResponseInterface::HTTP_OK,
                            'block' => false,
                            'error' => false,
                            'delete' => false
                        ],
                        'message' => 'Success',
                        'result' => [
                            'user_image' => $fileName,
                            'full_name' => $us->full_name,
                            'email' => $us->email
                        ]
                    ];
                } else {
                    $response = [
                        'error' => [
                            'status_code' => ResponseInterface::HTTP_OK,
                            'block' => false,
                            'error' => true,
                            'delete' => false
                        ],
                        'message' => 'Failed',
                    ];
                }

                return $this->response->setJSON($response)->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
            }
        } catch (Exception $e) {

            $response = [
                'error' => [
                    'status_code' => ResponseInterface::HTTP_UNAUTHORIZED,
                    'block' => false,
                    'error' => true,
                    'delete' => false
                ],
                'message' => $e->getMessage()
            ];

            return Services::response()
                ->setJSON($response)
                ->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);

        }
    }

    public function privacy_terms() {
        $setting = new SettingModel();

        $set = $setting->find(1);

        $response = [
            'error' => [
                'status_code' => ResponseInterface::HTTP_UNAUTHORIZED,
                'block' => false,
                'error' => false,
                'delete' => false
            ],
            'message' => "Success",
            'result' => $set
        ];
        return $this->response->setJSON($response);
    }

    public function send_feedback() {
        $report = new ReportModel();

        $message = $this->request->getPost('message');
        $user_id = $this->request->getPost('user_id');

        $data = [
          'message' => $message,
          'user_id' => $user_id
        ];

        $add = $report->insert($data);

        if ($add) {
            $response = [
                'error' => [
                    'status_code' => ResponseInterface::HTTP_OK,
                    'block' => false,
                    'error' => false,
                    'delete' => false
                ],
                'message' => "Success",
            ];
        } else {
            $response = [
                'error' => [
                    'status_code' => ResponseInterface::HTTP_OK,
                    'block' => false,
                    'error' => true,
                    'delete' => false
                ],
                'message' => "Failed",
            ];

        }
        return $this->response->setJSON($response);
    }
}