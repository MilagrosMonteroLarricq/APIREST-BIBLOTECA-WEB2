<?php

require_once __DIR__ . '/jwt.php';

class JWTMiddleware extends Middleware {

    public function run($request, $response) {

        $auth_header = $_SERVER['HTTP_AUTHORIZATION'] ?? '';

        if (empty($auth_header) && function_exists('apache_request_headers')) {
            $headers = apache_request_headers();
            $auth_header = $headers['Authorization'] ?? $headers['authorization'] ?? '';
        }

        if (empty($auth_header)) {
            return $response->json("No autorizado", 401);
        }

        $auth_header = explode(' ', $auth_header);

        if (count($auth_header) != 2 || $auth_header[0] != 'Bearer') {
            return $response->json("Token inválido", 401);
        }

        $jwt = $auth_header[1];
        $jwt = trim($jwt, '""');
        
        
        $user = validateJWT($jwt);

        if (!$user) {
            return $response->json("Token inválido o expirado", 401);
        }

        $request->user = $user;
    }
}