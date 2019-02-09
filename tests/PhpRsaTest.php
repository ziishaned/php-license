<?php

namespace Tests;

use Ziishaned\PhpRsa\PhpRsa;
use PHPUnit\Framework\TestCase;

/**
 * Class PhpRsaTest
 *
 * @package Tests
 * @author  Zeeshan Ahmad <ziishaned@gmail.com>
 */
class DumperTest extends TestCase
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

    $license       = PhpRsa::generate($data, $privateKey);
    $parsedLicense = PhpRsa::parse($license, $publicKey);

    $this->assertIsString($license);
    $this->assertIsArray($parsedLicense);
  }
}
