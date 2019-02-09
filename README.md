<h1 align="center">
	<img height="90" src="https://image.flaticon.com/icons/svg/21/21226.svg" alt="Dumper.js - Dumps information about a variable" />
	<br> PHP License
</h1>
<p align="center">
  <a href="https://codecov.io/gh/ziishaned/php-license">
    <img src="https://img.shields.io/codecov/c/github/ziishaned/php-license.svg?style=flat" alt="Codecov" />
  </a>
  <a href="https://travis-ci.org/ziishaned/php-license">
    <img src="https://api.travis-ci.com/ziishaned/php-license.svg?branch=master" alt="Build Status" />
  </a>
  <a href="https://twitter.com/home?status=PHP%20License%20by%20%40ziishaned%20http%3A//github.com/ziishaned/php-license">
    <img src="https://img.shields.io/badge/twitter-tweet-blue.svg?style=flat-square"/>
  </a>
  <a href="https://twitter.com/ziishaned">
    <img src="https://img.shields.io/badge/feedback-@ziishaned-blue.svg?style=flat-square" />
  </a>
</p>

<p align="center"><code>php-license</code> is a library for generating and parsing license files.</p>

## Generating Key Pair

Make sure OpenSSL is configured on your machine.

1. Generate the Private key file by running the following command:
   ```bash
   openssl genpkey -algorithm RSA -out private_key.pem -pkeyopt rsa_keygen_bits:2048
   ```

2. Run the following command to generate public key:
   ```bash
   openssl rsa -pubout -in private_key.pem -out public_key.pem
   ```

## Installation

```bash
composer require php-license
```

## Usage

Before running the following code make sure you have the `public_key` and `private_key` files.

### Generating

```php
<?php

use Ziishaned\PhpLicense\PhpLicense;

$data = [
  "firstName" => "John",
  "lastName"  => "Doe",
  "email"     => "john_doe@email.com",
];

$privateKey = file_get_contents('path/to/private_key.pem');
$license    = PhpLicense::generate($data, $privateKey);

var_dump([
  "license" => $license,
]);
```

The above code will output the following result:

```json
{
  "license": "agW4Riht6xHEfbpDaZUcTCmZVHgGgCnzXc0+nqLAMjuS6ouuGQVv/JqjAuo89tUgTu3F7Q+WProPcNm1aXdavxj3xOxTJ3e2w0NSS09sBZONxG9MzzofqvYPCnu/I1WMLgaRXiiNJcz5WtqFLFSdTgehqU5VLO+eDhfWUeZ0EJlCtCLPu19hP56/+24+/tmnh4ySLc9tV+YGLYtpmt7Gyf+h3sbMO0SJMwe+XSuuTcUsIUDg3AQUlj7c4ctwhkdYkRyyjj27U09CgpWWgU5b3sXSqZ3DFdTNaP8sIVH3Y39b7/o+Gx7WIHzngCnczK58L81LTVwnkyzSBqKUT5oq4A=="
}
```

### Parsing

```php
<?php

use Ziishaned\PhpLicense\PhpLicense;

$license = 'agW4Riht6xHEfbpDaZUcTCmZVHgGgCnzXc0+nqLAMjuS6ouuGQVv/JqjAuo89tUgTu3F7Q+WProPcNm1aXdavxj3xOxTJ3e2w0NSS09sBZONxG9MzzofqvYPCnu/I1WMLgaRXiiNJcz5WtqFLFSdTgehqU5VLO+eDhfWUeZ0EJlCtCLPu19hP56/+24+/tmnh4ySLc9tV+YGLYtpmt7Gyf+h3sbMO0SJMwe+XSuuTcUsIUDg3AQUlj7c4ctwhkdYkRyyjj27U09CgpWWgU5b3sXSqZ3DFdTNaP8sIVH3Y39b7/o+Gx7WIHzngCnczK58L81LTVwnkyzSBqKUT5oq4A==';

$publicKey     = file_get_contents('path/to/public_key.pem');
$parsedLicense = PhpLicense::parse($license, $publicKey);

var_dump([
  "parsedLicense" => $parsedLicense,
]);
```

The above code will output the following result:

```json
{
  "parsedLicense": {
    "firstName": "John",
    "lastName": "Doe",
    "email": "john_doe@email.com"
  }
}
```

## Contributions

Feel free to submit pull requests, create issues or spread the word.

## License

MIT &copy; [Zeeshan Ahmad](https://twitter.com/ziishaned)
