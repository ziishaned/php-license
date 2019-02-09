<?php

namespace Ziishaned\PhpLicense;

use Ziishaned\PhpLicense\Exception\BaseException;

class PhpLicense
{
    /**
     * Generate license file.
     *
     * @param array  $data
     * @param string $privateKey
     *
     * @return string
     * @throws \Ziishaned\PhpLicense\Exception\BaseException
     */
    public static function generate($data, $privateKey)
    {
        $key = openssl_pkey_get_private($privateKey);
        if (!$key) {
            throw new BaseException("OpenSSL: Unable to get private key");
        }

        $success = openssl_private_encrypt(json_encode($data), $signature, $key);
        openssl_free_key($key);

        if (!$success) {
            throw new BaseException("OpenSSL: Enable to generate signature");
        }

        $sign_b64 = base64_encode($signature);

        return $sign_b64;
    }

    /**
     * Parse license file.
     *
     * @param string $licenseKey
     * @param string $publicKey
     *
     * @return string
     * @throws \Ziishaned\PhpLicense\Exception\BaseException
     */
    public static function parse($licenseKey, $publicKey)
    {
        $sign = base64_decode($licenseKey);

        $key = openssl_pkey_get_public($publicKey);
        if (!$key) {
            throw new BaseException("OpenSSL: Unable to get public key");
        }

        $success = openssl_public_decrypt($sign, $decryptedData, $publicKey);
        openssl_free_key($key);

        if (!$success) {
            throw new BaseException("OpenSSL: Enable to generate signature");
        }

        return json_decode($decryptedData, true);
    }
}
