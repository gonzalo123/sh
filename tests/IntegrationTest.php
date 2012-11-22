<?php

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