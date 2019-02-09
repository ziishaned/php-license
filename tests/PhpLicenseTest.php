<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Ziishaned\PhpLicense\PhpLicense;

/**
 * Class PhpLicenseTest
 *
 * @package Tests
 * @author  Zeeshan Ahmad <ziishaned@gmail.com>
 */
class PhpLicenseTest extends TestCase
{
    /**
     * @throws \Exception
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

    /**
     * @throws \Exception
     */
    public function testCanThrowExceptionForWrongPublicKey()
    {
        $data       = [
            "email" => "ziishaned@gmail.com",
        ];
        $privateKey = '';

        try {
            PhpLicense::generate($data, $privateKey);
        } catch (\Exception $e) {
            $this->assertIsString($e->getMessage());
            $this->assertEquals($e->getMessage(), 'OpenSSL: Unable to get private key');
        }
    }

    /**
     * @throws \Exception
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
        } catch (\Exception $e) {
            $this->assertIsString($e->getMessage());
            $this->assertEquals($e->getMessage(), 'OpenSSL: Unable to get public key');
        }
    }
}
