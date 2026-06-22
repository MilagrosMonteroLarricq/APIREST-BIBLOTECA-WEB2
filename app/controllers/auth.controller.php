<?php

require_once __DIR__ . '/../models/users.model.php';
require_once __DIR__ . '/../../libs/jwt/jwt.php';

class AuthController {

    private $model;

    public function __construct() {
        $this->model = new UsersModel();
    }

   public function login($req, $res) {

        $email = $req->body->email ?? '';
        $password = $req->body->password ?? '';

        $user = $this->model->getByEmail($email);

        if (!$user || !password_verify($password, $user->password)) {
            return $res->json("Usuario o contraseña incorrectos", 401);
        }

        $payload = [
            'id' => $user->id_usuario,
            'email' => $user->email,
            'rol' => $user->rol,
            'exp' => time() + 3600
        ];

        $token = createJWT($payload);

        return $res->json($token, 200);
    }
}