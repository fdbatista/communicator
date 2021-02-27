<?php
declare(strict_types=1);

namespace app\utils;

class EncryptUtil
{
    private static $OPTIONS = 0;

    public static function encrypt(string $message)
    {
        $params = self::getEncParams();

        return openssl_encrypt($message, $params['cypher'], $params['key'], self::$OPTIONS, $params['iv']);
    }

    public static function decrypt($message)
    {
        $params = self::getEncParams();

        return openssl_decrypt($message, $params['cypher'], $params['key'], self::$OPTIONS, $params['iv']);
    }

    private static function getEncParams(): array
    {
        return [
            'iv' => env('ENC_IV'),
            'key' => env('ENC_KEY'),
            'cypher' => env('ENC_CYPHER'),
        ];
    }
}