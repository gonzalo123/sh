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

class IntegrationTest extends \PHPUnit_Framework_TestCase
{
    private $sh;
    private $directory;

    public function setUp()
    {
        $this->sh        = new Sh;
        $this->directory = __DIR__ . '/fixtures';
        chdir($this->directory);
    }

    public function testSimpleCommand()
    {
        $this->assertEquals($this->directory, $this->sh->pwd());
    }

    public function testSimpleCommandWithCommandAsAVariable()
    {
        $this->assertEquals($this->directory, $this->sh->runCommand('pwd'));
    }

    public function testSimpleCommandWithArguments()
    {
        $this->assertEquals("bar\nfoo", $this->sh->ls("-A"));
    }

    public function testSimpleCommandWithArgumentsWithCommandAsAVariable()
    {
        $this->assertEquals("bar\nfoo", $this->sh->runCommand('ls', "-A"));
    }

    public function testSimpleCommandWithMoreArguments()
    {
        $expected = "BakingTest.php\nfixtures\nIntegrationTest.php\nParserTest.php";
        $actual   = $this->sh->ls(".. -A");
        $this->assertEquals($expected, $actual);
    }
}