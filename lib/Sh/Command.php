<?php

/*
 * This file is part of the gonzalo123/sh package.
 *
 * (c) Gonzalo Ayuso <gonzalo123@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sh;

use Symfony\Component\Process\Process;

class Command
{
    private $name;
    private $lineCallback;
    private $commandArgument;

    /** @var \Sh\Sh */
    private $sh;

    public function __construct($name, $commandArgument = null)
    {
        $this->name = $name;
        $parser = new Parser($commandArgument);
        $this->commandArgument = $parser->getParsedArguments();
    }

    function __toString()
    {
        $output = null;
        $commandString = $this->getCommandString();

        $process = new Process($commandString);
        $process->setTimeout($this->sh->getTimeout());

        $process->run();

        return trim($process->getOutput());
    }

    public function doCallback()
    {
        $output        = null;
        $process = new Process($this->getCommandString());
        $process->setTimeout($this->sh->getTimeout());
        $process->run(function ($type, $buffer) {
                call_user_func_array($this->lineCallback, array($buffer, $type));
            }
        );

        return;
    }

    public function __call($name, $arguments)
    {
        $comandArgument = isset($arguments[0]) ? $arguments[0] : null;
        $lineCallback = isset($arguments[1]) ? $arguments[1] : null;

        $command = new Command($this->name, $this->getMixedArguments($name, $comandArgument));
        $command->setSh($this->sh);
        $command->setLineCallback($lineCallback);

        return $command;
    }

    private function getMixedArguments($name, $comandArgument)
    {
        $mixedArguments = array($this->commandArgument, $name);
        if (!is_null($comandArgument)) {
            $parser = new Parser($comandArgument);
            $mixedArguments[] = $parser->getParsedArguments();
        }
        return implode(' ',  $mixedArguments);
    }

    public function getString()
    {
        return $this->getCommandString();
    }

    private function getCommandString()
    {
        return is_null($this->commandArgument) ? $this->name : $this->name . ' ' . $this->commandArgument;
    }

    public function setSh(Sh $sh)
    {
        $this->sh = $sh;
    }

    public function setLineCallback($lineCallback)
    {
        $this->lineCallback = $lineCallback;
    }
}
