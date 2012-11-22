<?php
namespace Sh;

use Symfony\Component\Process\Process;

class Parser
{
    private $arguments;
    private $parsedArguments;

    public function __construct($parsedArguments = null)
    {
        $this->arguments = $parsedArguments;
        $this->parsedArguments = $this->parseArguments();
    }

    private function parseArguments()
    {
        $out = null;

        if (is_array($this->arguments)) {
            $out = array();
            foreach ($this->arguments as $key => $value) {
                $value = $this->surroundItemsWithSpacesWithQuotes($value);
                $out[] = (is_string($key)) ? "{$key} {$value}" : $value;
            }
            $out = implode(' ', $out);
        } else {
            $out = $this->arguments;
        }
        return $out;
    }

    private function surroundItemsWithSpacesWithQuotes($item)
    {
        return strpos($item, ' ') !== false ? "\"{$item}\"" : $item;
    }

    public function getParsedArguments()
    {
        return $this->parsedArguments;
    }
}
