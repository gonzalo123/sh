<?php
namespace Sh;

use Symfony\Component\Process\Process;

class Parser
{
    public function getCommandToProcess($name, $commandArgument = NULL)
    {
        if (is_null($commandArgument)) return $name;

        if (is_array($commandArgument)) {
            $commandArgument = implode(' ', $this->surroundItemsWithSpacesWithQuotes($commandArgument));
        }

        return $name . ' ' . $commandArgument;
    }

    private function surroundItemsWithSpacesWithQuotes($commandArgument)
    {
        return array_map(function ($item) {
            return strpos($item, ' ') !== FALSE ? "'{$item}'" : $item;
        }, $commandArgument);
    }
}
