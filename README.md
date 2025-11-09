# checkHost

# About

These repository are a php class for check-host.net and you can send ping, http, tcp, dns requests through it.

# How to install by composer

```
composer require alirezax5/check-host
```

# How to work:

1 - Create an object from the CheckHost class and write the desired host as a parameter inside it

```php
<?php
require 'vendor/autoload.php';

$CheckHost = new \Alirezax5\CheckHost\CheckHost('1.1.1.1');

```

2 - Choose the method you want based on the type of request and write it in your code.

```php
print_r($CheckHost->ping());
print_r($CheckHost->http());
print_r($CheckHost->dns());
print_r($CheckHost->tcp());
```
3 - If you want to receive a specific node, send the name of that node as below:

```php
$CheckHost->node('ir1')->node('ir4');
```
You can send from the method as a chain

Code in full:
```php
<?php
require 'vendor/autoload.php';

$CheckHost = new \Alirezax5\CheckHost\CheckHost('1.1.1.1');
print_r($CheckHost->ping());
print_r($CheckHost->http());
print_r($CheckHost->dns());
print_r($CheckHost->tcp());

//some node
$CheckHost->node('ir1')->node('ir4');
print_r($CheckHost->ping());
```

# Donate

To support me, you can star this repository or donate via the following currencies

- TON
```
UQBnlnOGefCkwgtO7IZdOBFuoojkpKgK3mI1GmH3MH_gG0A9
```

