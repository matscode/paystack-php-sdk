# Paystack PHP SDK
[SDK API]( https://matscode.github.io/paystack-php-sdk ) | [SDK Demo](https://github.com/matscode/paystack-php-sdk-sandbox)

### Available resources
- Transaction (`Initialize`, `List`, `Verify`)
- Bank (`List`, `Resolve account`)

### Resource roadmap
More resources would be added in time
- `Customers`
- `Plans`
- `Subscription`
- `Transfers`
- `others...`

This SDK communicates with [Paystack API](https://paystack.com/). You need to have a paystack merchant account and paystack secret key to use this SDK.

Development is actively ongoing while releases are Stable.
<br>
If you find a BUG/Security Issue, do be kind to open an issue or email [Me](mailto:matscode@gmail.com).

## Requirements
 - GuzzleHttp

## Installation
``` bash
composer require matscode/paystack-php-sdk
```

``` php
require_once __DIR__ . "/vendor/autoload.php";
```

### Manual
- Download the archive
- Extract into your project
- And lastly
    ``` php
    require_once __DIR__ . "/vendor/autoload.php";
    ```

### Initialize Paystack
``` php
use Matscode\Paystack\Paystack;

$paystackSecret = 'sk_test_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
$Paystack = new Paystack($paystackSecret);
```

## Transaction Resource
#### Initialize Charge
```php
$response = $Paystack->trasaction->initialize([
            'email'  => 'customer.email@gmail.com',
            'amount' => 500000, // amount is in kobo
            'callback_url' => 'https://www.app.local/paystack/transaction/verify'
        ]);
```
OR 
``` php
// Set data to post using this method
$response = $Paystack->trasaction
            ->setCallbackUrl('https://www.app.local/paystack/transaction/verify')
            ->setEmail('customer.email@gmail.com')
            ->setAmount(75000) // amount is treated in Naira while using this setAmount() method
            ->initialize();
```
Now do a redirect to payment page (using authorization_url)
<br>
Recommended to check if `authorization_url` is set, and save your transaction reference code. useful to verify Transaction status

``` php
// recommend to save Transaction reference in database and do a redirect
header('Location: ' . $response->data->authorization_url);
```

#### Verifying Transaction
``` php
$reference_code = $_GET['reference']
$response = $Paystack->trasaction->verify($reference_code);
```
OR
``` php
// This method does the check for you and return `(bool) true|false` 
$response = $Paystack->transaction->isSuccessful($reference_code);
```

## Bank Resource
#### Get list of banks
```php
$response = $Paystack->bank->list();
```

#### Resolve account info
```php
$bank_code='0000';
$account_number='0987654321'
$response = $Paystack->bank->resolve($bank_code, $account_number); 
//result: returns account information is found, throws exception otherwise
```


### Contact
[Personal Home](https://inndex.page/matscode) | [Email](mailto:matscode@gmail.com)
