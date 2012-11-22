<?php

use Sh\Parser;

class ParserTest extends \PHPUnit_Framework_TestCase
{
    private $parser;

    public function dataProvider()
    {
        return array(
            array(
                'expected'      => '',
                'arguments'     => NULL),
            array(
                'expected'      => '-fuax',
                'arguments'     => '-fuax'),
            array(
                'expected'      => '-fuax',
                'arguments'     => array('-fuax')),
            array(
                'expected'      => '-latr ~/fixtures',
                'arguments'     => array('-latr', '~/fixtures')),
            array(
                'expected'      => '-t 5000 title HOLA',
                'arguments'     => array('-t', 5000, 'title', 'HOLA')),
            array(
                'expected'      => '-t 5000 title "Hola Gonzalo"',
                'arguments'     => array('-t', 5000, 'title' => 'Hola Gonzalo')
            ),
        );
    }

    /**
     * @dataProvider dataProvider
     */
    public function testParser($expected, $arguments)
    {
        $parser = new Parser($arguments);
        $parsedArguments = $parser->getParsedArguments();

        $this->assertEquals($expected, $parsedArguments);
    }
}