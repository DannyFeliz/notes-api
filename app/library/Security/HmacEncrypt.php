<?php
/**
 * Hash Message Authentication Code
 *
 * @package Security
 * @version 1.0
 */
namespace Notes\Security;

class HmacEncrypt
{
    private static $hashType = 'sha256';

    /**
     * Generate a Hash content
     *
     * @param string $contents msg content
     * @param string $privateKey api private key
     * @return string
     */
    public static function generate($contents, $privateKey)
    {
        return hash_hmac(self::$hashType, $contents, $privateKey);
    }

    /**
     * See if too hashs match up
     *
     * @param string
     * @param string
     * @return bool
     */
    public static function isMatch($hash1, $hash2)
    {
        return $hash1 === $hash2;
    }
}
