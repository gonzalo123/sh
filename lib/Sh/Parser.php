<?php
namespace Sh;

use Symfony\Component\Process\Process;

class Parser
{
    public function getCommandToProcess($name, $commandArgument = NULL)
    {
        if (is_null($commandArgument)) return $name;

        if (is_array($commandArgument)) {
            $out = array();
            foreach ($commandArgument as $key => $value) {
                $value = $this->surroundItemsWithSpacesWithQuotes($value);
                $out[] = (is_string($key)) ? "{$key} {$value}" : $value;
            }

            $commandArgument = implode(' ', $out);
        }

        return $name . ' ' . $commandArgument;
    }

    private function surroundItemsWithSpacesWithQuotes($item)
    {
        return strpos($item, ' ') !== FALSE ? "\"{$item}\"" : $item;
    }
}
