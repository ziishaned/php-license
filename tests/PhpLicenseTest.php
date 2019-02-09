<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Ziishaned\PhpLicense\PhpLicense;
use Ziishaned\PhpLicense\Exception\BaseException;

/**
 * Class PhpLicenseTest
 *
 * @package Tests
 * @author  Zeeshan Ahmad <ziishaned@gmail.com>
 */
class PhpLicenseTest extends TestCase
{
    /**
     * @throws \Ziishaned\PhpLicense\Exception\BaseException
     */
    public function testCanGenerateLicenseKey()
    {
        $data       = [
            "email" => "ziishaned@gmail.com",
        ];
        $privateKey = file_get_contents(__DIR__ . '/keys/private_key.pem');

        $license = PhpLicense::generate($data, $privateKey);

        $this->assertIsString($license);
    }

    public function testCanThrowExceptionForWrongPublicKey()
    {
        $data       = [
            "email" => "ziishaned@gmail.com",
        ];
        $privateKey = '';

        try {
            PhpLicense::generate($data, $privateKey);
        } catch (BaseException $e) {
            $this->assertIsString($e->getMessage());
            $this->assertStringContainsString('OpenSSL: Unable to get private key', $e->getMessage());
        }
    }

    /**
     * @throws \Ziishaned\PhpLicense\Exception\BaseException
     */
    public function testCanParseLicenseKey()
    {
        $data       = [
            "email" => "ziishaned@gmail.com",
        ];
        $publicKey  = file_get_contents(__DIR__ . '/keys/public_key.pem');
        $privateKey = file_get_contents(__DIR__ . '/keys/private_key.pem');

        $license       = PhpLicense::generate($data, $privateKey);
        $parsedLicense = PhpLicense::parse($license, $publicKey);

        $this->assertIsString($license);
        $this->assertIsArray($parsedLicense);
    }

    public function testCanThrowExceptionForWrongPrivateKey()
    {
        $licenseKey = 'license-key';
        $privateKey = '';

        try {
            PhpLicense::parse($licenseKey, $privateKey);
        } catch (BaseException $e) {
            $this->assertIsString($e->getMessage());
            $this->assertStringContainsString('OpenSSL: Unable to get public key', $e->getMessage());
        }
    }
}
