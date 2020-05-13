<?php

namespace App\Lib;

use Log;

class ExecutableCommand
{
    private $execCommand;
    private $availableSubCommands = [];
    private $availableOptions = [];

    public function __construct(string $execCommand, array $availableSubCommands = null, array $availableOptions = null)
    {
        $isCorrectArgument = true;
        if ($availableSubCommands) {
            $isCorrectArgument |= TypeCheck::checkArrayType('string', $availableSubCommands);
        }

        if ($availableOptions) {
            $isCorrectArgument |= TypeCheck::checkArrayType('string', $availableOptions);
        }

        if (!$isCorrectArgument) {
            throw new \InvalidArgumentException('Bad Argument');
        }

        $availableCommands = config('app.availableCommands');
        if (!\in_array($execCommand, $availableCommands)) {
            throw new \InvalidArgumentException('This command is not permitted. : ' . $execCommand . PHP_EOL);
        }

        $this->execCommand = $execCommand;
        $this->availableSubCommands = $availableSubCommands;
        $this->availableOptions = $availableOptions;
    }

    public function exec(string $subCommand = null, string ...$args)
    {
        if (!$this->isPermitted($subCommand, $args)) {
            return false;
        }

        $isFailed = false;
        $argument = implode(' ', $args);
        $execLine = $this->execCommand;
        if ($subCommand) {
            $execLine .= ' ' . $subCommand;
        }

        if (count($args) > 0) {
            $execLine .= ' ' . $argument;
        }

        \exec($execLine, $output, $isFailed);
        if ($isFailed) {
            \exec('whoami', $execUserName);
            Log::error('Failed "' . $execLine . '" by ' . $execUserName[0]);
            return false;
        } else {
            Log::info('Success to exec command: "' . $execLine . '"');
            return $output;
        }
    }

    protected function isPermitted(string $subCommand = null, array $args = []): bool
    {
        $isPermitted = true;

        if ($subCommand && !$this->isAvailableSubCommands($subCommand)) {
            Log::error('This sub command is not permitted. : ' . $subCommand . PHP_EOL);
            $isPermitted = false;
        }

        foreach ($args as $arg) {
            $execArgument = '';
            if (strncmp($arg, '-', 1) === 0) {
                $optionName = $this->getOptionName($arg);

                if (!$this->isAvailableOption($optionName)) {
                    Log::error('This option is not permitted. : ' . $optionName . PHP_EOL);
                    $isPermitted = false;
                }
            }
        }

        return $isPermitted;
    }

    protected function isAvailableSubCommands(string $subCommand): bool
    {
        if (\in_array($subCommand, $this->availableSubCommands, true)) {
            return true;
        } else {
            return false;
        }
    }

    protected function isAvailableOption(string $option): bool
    {
        if (\in_array($option, $this->availableOptions, true)) {
            return true;
        } else {
            return false;
        }
    }

    protected function getOptionName(string $argument)
    {
        return \strstr($argument, ' ', true) ?: $argument;
    }
}
