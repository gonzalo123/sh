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

class Sh
{
    const DEFAULT_TIMEOUT = 3600;
    private $timeout;

    /**
     * @param int|null $timeout
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
     * @param null|string|array  $comandArgument
     * @param null|Callable      $lineCallback
     * @return null|string
     */
    public function runCommand($name, $comandArgument = null, $lineCallback = null)
    {
        $output  = null;
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
        $comandArgument = isset($arguments[0]) ? $arguments[0] : null;
        $lineCallback   = isset($arguments[1]) ? $arguments[1] : null;

        return $this->runCommand($name, $comandArgument, $lineCallback);
    }

    public function getTimeout()
    {
        return $this->timeout;
    }
}
