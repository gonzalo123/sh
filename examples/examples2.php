<?php
error_reporting(-1);

// include PSR-0 autoloader
include __DIR__ . '/../vendor/autoload.php';

use Sh\Sh;

$sh = new Sh();

$sh->tail('-f /var/log/apache2/access.log', function ($buffer) {
        echo $buffer;
    }
);
