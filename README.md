# HotRecharge PHP Library

This is a PHP library for interacting with the HotRecharge API, allowing you to perform various operations such as recharging, querying transactions, and more.

# Getting Started
Install the library using Composer:

composer require tinosoft/hot-recharge

Configure authentication by creating an instance of HRAuthConfig and using it to initialize HotRecharge.

Use the library to perform various HotRecharge operations as needed.

Feel free to explore the library's functions and adapt them for your specific use case.

For more details and usage examples, refer to the code and documentation.

License
This project is licensed under the MIT License - see the LICENSE file for details.


## Authentication Header

To use this library, you need to set up authentication details using the `HRAuthConfig` class. Here's how you can configure it:

```php
require 'vendor/autoload.php';

use HotRecharge\HotRecharge;
use HotRecharge\HRAuthConfig;

$authConfig = new HRAuthConfig('your-access-code', 'your-access-password');
$hotRecharge = new HotRecharge($authConfig);



## Usage Examples

## Recharging Example
$res = $hotRecharge->rechargeZesa('recipient_mobile_number', 'voucher_code', 'amount');
echo $res;

recipient_mobile_number: The mobile number of the recipient.
voucher_code: The voucher code for recharging.
amount: The recharge amount.
Query Transaction Example

## Query Transaction Example
$res = $hotRecharge->queryTransaction('agent_reference');
echo $res;

agent_reference: The agent reference for the transaction you want to query.
