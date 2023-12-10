<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use Exception;

class JwtAuthFilter implements FilterInterface
{

    public function before(RequestInterface $request, $arguments = null)
    {
        $authenticationHeader = $request->getServer('HTTP_AUTHORIZATION');

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

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {

    }
}