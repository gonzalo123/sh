<?php
namespace Sh;

use Symfony\Component\Process\Process;

class Parser
{
    public function getCommandToProcess($name, $commandArgument = null)
    {
        if (is_array($commandArgument)) {
            $out = array();
            foreach ($commandArgument as $key => $value) {
                $value = $this->surroundItemsWithSpacesWithQuotes($value);
                $out[] = (is_string($key)) ? "{$key} {$value}" : $value;
            }

            $commandArgument = implode(' ', $out);
        }

        return new Command($name, $commandArgument);
    }

    private function surroundItemsWithSpacesWithQuotes($item)
    {
        return strpos($item, ' ') !== false ? "\"{$item}\"" : $item;
    }
}
