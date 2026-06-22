<?php
function base64UrlEncode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function base64UrlDecode($data) {
    return base64_decode(strtr($data, '-_', '+/'));
}

function createJWT($payload) {

    $header = [
        'typ' => 'JWT',
        'alg' => 'HS256'
    ];

    $header = base64UrlEncode(json_encode($header));
    $payload = base64UrlEncode(json_encode($payload));

    $signature = hash_hmac(
        'sha256',
        $header . "." . $payload,
        'mi1secreto',
        true
    );

    $signature = base64UrlEncode($signature);

    return $header . "." . $payload . "." . $signature;
}

function validateJWT($jwt) {

    $parts = explode('.', $jwt);

    if (count($parts) != 3) {
        return null;
    }

    $header = $parts[0];
    $payload = $parts[1];
    $signature = $parts[2];

    $expected = hash_hmac(
        'sha256',
        $header . "." . $payload,
        'mi1secreto',
        true
    );

    $expected = base64UrlEncode($expected);

    if ($signature !== $expected) {
        return null;
    }

    $payload = json_decode(base64UrlDecode($payload));

    if (!$payload) {
        return null;
    }

    if ($payload->exp < time()) {
        return null;
    }

    return $payload;
}