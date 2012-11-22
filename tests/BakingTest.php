<?php

/*
 * This file is part of the gonzalo123/sh package.
 *
 * (c) Gonzalo Ayuso <gonzalo123@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Sh\Sh;

class BakingTest extends \PHPUnit_Framework_TestCase
{
    private $sh;
    private $directory;

    public function setUp()
    {
        $this->sh = new Sh;
        $this->directory = __DIR__ . '/fixtures';
        chdir($this->directory);
    }

    public function testBake1()
    {
        $comand = $this->sh->ssh(array('myserver.com', '-p' => 1393))->whoami()->getString();

        $this->assertEquals('ssh myserver.com -p 1393 whoami', $comand);
    }

    public function testBake2()
    {
        $comand = $this->sh
                ->ssh(array('myserver.com', '-p' => 1393))
                ->tail(array("/var/log/dumb_daemon.log", '-n' => 100))
                ->getString();

        $this->assertEquals('ssh myserver.com -p 1393 tail /var/log/dumb_daemon.log -n 100', $comand);
    }
}