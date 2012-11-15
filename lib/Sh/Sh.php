<?php
namespace Sh;

use Symfony\Component\Process\Process;

class Sh
{
    const DEFAULT_TIMEOUT = 3600;
    private $timeout;
    private $parser;

    /**
     * @param int|NULL $timeout
     */
    public function __construct($timeout = self::DEFAULT_TIMEOUT)
    {
        $this->setTimeout($timeout);
        $this->parser = new Parser;
    }

    public static function factory($timeout = self::DEFAULT_TIMEOUT)
    {
        return new self($timeout);
    }

    /**
     * @param string             $name
     * @param NULL|string|array  $comandArgument
     * @param NULL|Closure       $lineCallback
     * @return NULL|string
     * @throws RuntimeException
     */
    public function runCommnad($name, $comandArgument = NULL, $lineCallback = NULL)
    {
        $output  = NULL;
        $process = new Process($this->parser->getCommandToProcess($name, $comandArgument));
        $process->setTimeout($this->timeout);

        if (is_callable($lineCallback)) {
            $process->run(function ($type, $buffer) use ($lineCallback) {
                call_user_func_array($lineCallback, array($buffer, $type));
            });
            ;
        } else {
            $process->run();
            $output = $process->getOutput();
        }

        return trim($output);
    }

    private function getCommandToProcess($name, $comandArgument)
    {
        if (is_array($comandArgument)) {
            $comandArgument = implode(' ', $comandArgument);
        }

        return $name . ' ' . $comandArgument;
    }

    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;
    }

    public function __call($name, $arguments)
    {
        $comandArgument = isset($arguments[0]) ? $arguments[0] : NULL;
        $lineCallback   = isset($arguments[1]) ? $arguments[1] : NULL;

        return $this->runCommnad($name, $comandArgument, $lineCallback);
    }
}
