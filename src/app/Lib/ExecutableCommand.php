<?php

namespace App\Lib;

use Log;

/**
 * Command execute base class.
 */
class ExecutableCommand
{
    private $execCommand;
    private $availableSubCommands = [];
    private $availableOptions = [];

    // @TODO availableSubCommandsに配列渡して，サブコマンドごとにavailableOptionを指定したい．
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

    /**
     * Execute Command
     *
     * This method is to execute "class subcommand" on the shell if subcommand is permitted.
     *
     * @param string $subCommand
     * @param string ...$args
     * @return void
     */
    public function exec(string $subCommand = null, string ...$args)
    {
        // $this->bashEscape($args);
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

    /**
     * This method is to check subCommand is permitted.
     *
     * @param string $subCommand
     * @param array $args
     * @return boolean
     */
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

    // Dockerの方に書いて，コンテナ名に使用できる文字列だけにしたほうがいいかも
    // private function bashEscape(array $str)
    // {
    //     foreach ($str as $value) {
    //         exec('printf %q\'' . $value . )
    //     }
    // }
}
