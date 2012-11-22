<?php
namespace Sh;

class Sh
{
    const DEFAULT_TIMEOUT = 3600;
    private $timeout;

    /**
     * @param int|NULL $timeout
     */
    public function __construct($timeout = self::DEFAULT_TIMEOUT)
    {
        $this->setTimeout($timeout);
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

        $command = new Command($name, $comandArgument);
        $command->setSh($this);
        $command->setLineCallback($lineCallback);

        return $command;
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
        return $this;
    }

    public function __call($name, $arguments)
    {
        $comandArgument = isset($arguments[0]) ? $arguments[0] : NULL;
        $lineCallback   = isset($arguments[1]) ? $arguments[1] : NULL;

        return $this->runCommnad($name, $comandArgument, $lineCallback);
    }

    public function getTimeout()
    {
        return $this->timeout;
    }
}
