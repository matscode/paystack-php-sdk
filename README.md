# Paystack PHP SDK  &nbsp;&nbsp;  [![aislop](https://badges.scanaislop.com/score/matscode/paystack-php-sdk.svg)](https://scanaislop.com/matscode/paystack-php-sdk)

### [Full Documentation]( https://matscode.github.io/paystack-php-sdk )

For version 1 of this SDK, visit [matscode/paystack](https://github.com/matscode/paystack).

### Available resources
- **Transaction** (`Initialize`, `List`, `Verify`, `isSuccessful`, Fluent Setters)
- **Plan** (`Create`, `List`, `Fetch`, `Update`)
- **Subscription** (`Create`, `List`, `Fetch`, `Disable`, `Enable`)
- **Miscellaneous** (`Bank`, `Country`, `Card`)

### Resource roadmap
More resources would be added in time
- `Transfers`
- `others...`

This SDK communicates with [Paystack API](https://paystack.com/). You need to have a paystack merchant account and paystack secret key to use this SDK.

Development is actively ongoing while releases are Stable.
<br>
If you find a BUG/Security Issue, do be kind to open an issue or [contact me](https://matsco.de).

## Requirements
 - GuzzleHttp
 - PHP 7.4+ / 8.x

## Installation
``` bash
composer require matscode/paystack-php-sdk
```

### Manual
- Download the archive
- Extract into your project
- And lastly
    ``` php
    require_once __DIR__ . "/vendor/autoload.php";
    ```

## Initialize Paystack SDK
``` php
use Matscode\Paystack\Paystack;

$paystackSecret = 'sk_test_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
$Paystack = new Paystack($paystackSecret);
```

---

## Transaction Resource
#### Initialize Charge
```php
$response = $Paystack->transaction->initialize([
    'email'  => 'customer.email@gmail.com',
    'amount' => 500000, // amount is in kobo
    'callback_url' => 'https://www.app.local/paystack/transaction/verify'
]);
```
OR 
``` php
// Set data to post using fluent methods
$response = $Paystack->transaction
    ->setCallbackUrl('https://www.app.local/paystack/transaction/verify')
    ->setEmail('customer.email@gmail.com')
    ->setAmount(75000) // amount is treated in kobo/pesewas
    ->initialize();
```
Now do a redirect to payment page (using authorization_url)
<br>
Recommended to check if `authorization_url` is set, and save your transaction reference code useful to verify Transaction status.

``` php
header('Location: ' . $response->data->authorization_url);
```

#### Verifying Transaction
``` php
$reference_code = $_GET['reference'];
$response = $Paystack->transaction->verify($reference_code);
```
OR
``` php
// This method does the check for you and returns `(bool) true|false` 
$isSuccessful = $Paystack->transaction->isSuccessful($reference_code);
```

#### List Transactions
```php
$response = $Paystack->transaction->list(50, 1);
```

---

## Miscellaneous Resources

#### Get list of banks
```php
// Supports optional filters such as country, perPage, use_cursor, etc.
$response = $Paystack->miscellaneous->bank->list(['country' => 'nigeria']);
```

#### Resolve account info
```php
$bank_code = '063';
$account_number = '0022728151';
$response = $Paystack->miscellaneous->bank->resolve($bank_code, $account_number); 
```

#### Validate account info
```php
$response = $Paystack->miscellaneous->bank->validate([
    'bank_code' => '632005',
    'country_code' => 'ZA',
    'account_number' => '0123456789',
    'account_name' => 'Ann Bron',
    'account_type' => 'personal',
    'document_type' => 'identityNumber',
    'document_number' => '1234567890123'
]);
```

#### Get supported countries
```php
$response = $Paystack->miscellaneous->country->list();
```

#### Resolve Card Information (BIN lookup)
```php
// Shields underlying fintech complexity behind a clean method name
$response = $Paystack->miscellaneous->card->resolveInfo('539983');
```

---

## Plan Resource
#### Create a plan
```php
$response = $Paystack->plan->create([
    'name' => 'Monthly Retainer',
    'amount' => 500000,
    'interval' => 'monthly'
]);
```

#### List, Fetch, and Update Plans
```php
$plans = $Paystack->plan->list();
$plan = $Paystack->plan->fetch('PLN_xxxxxx');
$updated = $Paystack->plan->update('PLN_xxxxxx', ['name' => 'Updated Plan Name']);
```

---

## Subscription Resource
#### Create a subscription
```php
$response = $Paystack->subscription->create([
    'customer' => 'CUS_xxxxxx',
    'plan' => 'PLN_xxxxxx'
]);
```

#### Manage Subscriptions
```php
$subscriptions = $Paystack->subscription->list();
$subscription = $Paystack->subscription->fetch('SUB_xxxxxx');

// Enable or disable
$Paystack->subscription->disable(['code' => 'SUB_xxxxxx', 'token' => 'SUB_tokenxxx']);
$Paystack->subscription->enable(['code' => 'SUB_xxxxxx', 'token' => 'SUB_tokenxxx']);
```

---

## Author
Michael Akanji - [matsco.de](https://matsco.de)