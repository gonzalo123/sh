<?php
namespace Sh;

use Symfony\Component\Process\Process;

class Command
{
    private $name;
    /** @var \Sh\Sh */
    private $sh;
    private $commandArgument;
    private $timeout;

    /** @var NULL|Callable  */
    private $lineCallback;

    public function __construct($name, $commandArgument = null)
    {
        $this->name = $name;
        $parser = new Parser($commandArgument);
        $this->commandArgument =  $parser->getParsedArguments();
    }

    function __toString()
    {
        $output = NULL;
        $commandString = $this->getCommandString();

        $process = new Process($commandString);
        $process->setTimeout($this->sh->getTimeout());

        if (is_callable($this->lineCallback)) {
            $process->run(function ($type, $buffer) {
                call_user_func_array($this->lineCallback, array($buffer, $type));
            });
        } else {
            $process->run();
            $output = $process->getOutput();
        }
        return trim($output);
    }

    public function __call($name, $arguments)
    {
        $comandArgument = isset($arguments[0]) ? $arguments[0] : NULL;
        $lineCallback = isset($arguments[1]) ? $arguments[1] : NULL;

        $mixedArguments = array($this->commandArgument, $name);
        if (!is_null($comandArgument)) {
            $parser = new Parser($comandArgument);
            $mixedArguments[] = $parser->getParsedArguments();
        }
        $command = new Command($this->name, implode(' ',  $mixedArguments));
        $command->setSh($this->sh);
        $command->setLineCallback($lineCallback);

        return $command;
    }

    public function getString()
    {
        return $this->getCommandString();
    }

    public function setLineCallback($lineCallback)
    {
        $this->lineCallback = $lineCallback;
    }

    private function getCommandString()
    {
        return is_null($this->commandArgument) ? $this->name : $this->name . ' ' . $this->commandArgument;
    }


    public function setSh(Sh $sh)
    {
        $this->sh = $sh;
    }
}
