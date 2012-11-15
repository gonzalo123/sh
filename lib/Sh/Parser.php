<?php
namespace Sh;

use Symfony\Component\Process\Process;

class Parser
{
    public function getCommandToProcess($name, $comandArgument = NULL)
    {
        if (is_null($comandArgument)) return $name;

        if (is_array($comandArgument)) {
            $comandArgument = implode(' ', $this->surroundItemsWithSpacesWithQuotes($comandArgument));
        }

        return $name . ' ' . $comandArgument;
    }

    private function surroundItemsWithSpacesWithQuotes($comandArgument)
    {
        return array_map(function ($item) {
            return strpos($item, ' ') !== FALSE ? "'{$item}'" : $item;
        }, $comandArgument);
    }
}
