<?php

use Sh\Sh;

class BakingTest extends \PHPUnit_Framework_TestCase
{
    private $sh;
    private $directory;

    public function setUp()
    {
        $this->sh        = new Sh;
        $this->directory = __DIR__ . '/fixtures';
        chdir($this->directory);
    }

    public function testBake()
    {
        $ls = $this->sh->ls('-la')->bake();
        $this->assertEquals('ls -la', $ls);
    }
}