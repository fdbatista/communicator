<?php
declare(strict_types=1);

namespace app\utils;

class EncryptionUtil
{
    private static int $OPTIONS = 0;

    private static string $CIPHERING = 'AES-128-CTR';
    private static string $IV = '1234567891011121';
    private static string $KEY = 'GeeksForGeeks';

    public static function encrypt(string $message)
    {
        return openssl_encrypt($message, self::$CIPHERING, self::$KEY, self::$OPTIONS, self::$IV);
    }

    public static function decrypt($message)
    {
        return openssl_decrypt($message, self::$CIPHERING, self::$KEY, self::$OPTIONS, self::$IV);
    }
}