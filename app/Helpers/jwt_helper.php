<?php

use App\Models\UserModel;
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function getJWTFromRequest($authenticationHeader): string
{
    if (is_null($authenticationHeader)) {
        throw new Exception('Missing or invalid JWT in request');
    }
    return explode(' ', $authenticationHeader)[1];
}

function validateJWTFromRequest(string $encodedToken)
{
    $key = (string) Services::getSecretKey();
    $decodedToken = JWT::decode($encodedToken, new Key(getenv('JWT_SECRET_KEY'), 'HS256'));
    $userModel = new UserModel();
    return $userModel->find($decodedToken->user_id);
}

function getSignedJWTForUser(string $user_id)
{
    $issuedAtTime = time();
    $tokenTimeToLive = getenv('JWT_TIME_TO_LIVE');
    $tokenExpiration = $issuedAtTime + $tokenTimeToLive;
    $payload = [
        'user_id' => $user_id,
        'iat' => $issuedAtTime,
        'exp' => $tokenExpiration,
    ];

    return JWT::encode($payload, getenv('JWT_SECRET_KEY'), 'HS256');
}