<?php

use Sh\Parser;

class ParserTest extends \PHPUnit_Framework_TestCase
{
    private $parser;

    public function setUp()
    {
        $this->parser = new Parser;
    }

    public function dataProvider()
    {
        return array(
            array(
                'expected'      => 'pwd',
                'actualCommand' => 'pwd',
                'arguments'     => NULL),
            array(
                'expected'      => 'ps -fuax',
                'actualCommand' => 'ps',
                'arguments'     => '-fuax'),
            array(
                'expected'      => 'ps -fuax',
                'actualCommand' => 'ps',
                'arguments'     => array('-fuax')),
            array(
                'expected'      => 'ls -latr ~/fixtures',
                'actualCommand' => 'ls',
                'arguments'     => array('-latr', '~/fixtures')),
            array(
                'expected'      => 'notify-send -t 5000 title HOLA',
                'actualCommand' => 'notify-send',
                'arguments'     => array('-t', 5000, 'title', 'HOLA')),
            array(
                'expected'      => "notify-send -t 5000 title 'Hola Gonzalo'",
                'actualCommand' => 'notify-send',
                'arguments'     => array('-t', 5000, 'title', 'Hola Gonzalo')
            ),
        );
    }

    /**
     * @dataProvider dataProvider
     */
    public function testParser($expected, $command, $arguments)
    {
        $this->assertEquals($expected, $this->parser->getCommandToProcess($command, $arguments));
    }
}