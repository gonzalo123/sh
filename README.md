Command line library for PHP that allows to call programs as functions.

[![Build Status](https://secure.travis-ci.org/gonzalo123/sh.png?branch=master)](https://travis-ci.org/gonzalo123/sh)

Inspired in Python Sh library (http://amoffat.github.com/sh/)

usage examples:


```php
<?php
error_reporting(-1);

// include PSR-0 autoloader
include __DIR__ . '/../vendor/autoload.php';

use Sh\Sh;

// Simple command using factory
echo Sh::factory()->runCommnad('notify-send', array('-t', 5000, 'title', 'HOLA'));

// with instance
$sh  = new Sh();
echo $sh->ifconfig("eth0");

echo $sh->ls('-latr ~');

echo $sh->ls(array('-latr', '~'));

$sh->tail('-f /var/log/apache2/access.log', function ($buffer)  {
    echo $buffer;
});

// chainable commands (baking)
$sh->ssh(array('myserver.com', '-p' => 1393))->whoami();
// executes: ssh myserver.com -p 1393 whoami

$sh->ssh(array('myserver.com', '-p' => 1393))->tail(array("/var/log/dumb_daemon.log", 'n' => 100));
// executes: ssh myserver.com -p 1393 tail /var/log/dumb_daemon.log -n 100
});
```