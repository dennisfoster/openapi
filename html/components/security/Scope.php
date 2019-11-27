<?php

namespace app\components\security;
use \UnexpectedValueException;

class Scope {

    public static function load($token) {
        $tks = explode('.', $token);
        if (count($tks) != 3) {
            throw new UnexpectedValueException('Wrong number of segments');
        }
        list($headb64, $bodyb64, $cryptob64) = $tks;
        if (null === $payload = JWT::jsonDecode(JWT::urlsafeB64Decode($bodyb64))) {
            throw new UnexpectedValueException('Invalid claims encoding');
        }

        return $payload->scope;
    }

}
