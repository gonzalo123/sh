<?php
namespace Sh;

use Symfony\Component\Process\Process;

class Command
{
    private $name;
    private $commandArgument;
    private $timeout;

    /** @var NULL|Callable  */
    private $lineCallback;

    public function __construct($name, $commandArgument = null)
    {
        $this->name = $name;
        $this->commandArgument = $commandArgument;
    }

    function __toString()
    {
        $output = NULL;
        $commandString = $this->getCommandString();
        $process = new Process($commandString);
        $process->setTimeout($this->timeout);

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

    public function bake()
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

    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;
        return $this;
    }
}
