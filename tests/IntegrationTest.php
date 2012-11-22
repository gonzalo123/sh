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

    public function testSimpleCommandWithCommnadAsAVariable()
    {
        $this->assertEquals($this->directory, $this->sh->runCommnad('pwd'));
    }

    public function testSimpleCommnadWithArguments()
    {
        $this->assertEquals("bar\nfoo", $this->sh->ls("-A"));
    }

    public function testSimpleCommnadWithArgumentsWithCommnadAsAVariable()
    {
        $this->assertEquals("bar\nfoo", $this->sh->runCommnad('ls', "-A"));
    }

    public function testSimpleCommnadWithMoreArguments()
    {
        $this->assertEquals("BakingTest.php\nfixtures\nIntegrationTest.php\nParserTest.php", $this->sh->ls(".. -A"));
    }

    public function testSimpleCommnadWithMoreArgumentsAsArray()
    {
        $this->assertEquals("BakingTest.php\nfixtures\nIntegrationTest.php\nParserTest.php", $this->sh->ls(array('..', '-A')));
    }
}