<?php

/*
 * This file is part of the gonzalo123/sh package.
 *
 * (c) Gonzalo Ayuso <gonzalo123@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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