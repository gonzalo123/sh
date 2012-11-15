Command line library for PHP that allows to call programs as functions.

Inspired in Python Sh library (http://amoffat.github.com/sh/)

usage examples:

```php
<?php
error_reporting(-1);

include __DIR__ . '/../vendor/autoload.php';

use Sh\Sh;

echo Sh::factory()->runCommnad('notify-send', ['-t', 5000, 'title', 'HOLA']);

$sh  = new Sh();
echo $sh->ifconfig("eth0");

echo $sh->ls('-latr ~');

echo $sh->ls(['-latr', '~']);

$sh->tail('-f /var/log/apache2/access.log', function ($buffer)  {
    echo $buffer;
});
```