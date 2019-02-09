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
    public function testCanGetLicense()
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
}
