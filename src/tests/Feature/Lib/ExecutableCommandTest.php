<?php

namespace Tests\Feature\Lib;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Lib\ExecutableCommand;

class ExecutableCommandTest extends TestCase
{
    public function testCorrectCase()
    {
        $correctResult = [
            'root',
        ];

        $ec = new ExecutableCommand('whoami');
        $result = $ec->exec();
        $this->assertEquals($correctResult, $result);
    }

    public function testCorrectCase_withSubcommand()
    {
        $correctResultSubset = [
            '1: lo: <LOOPBACK,UP,LOWER_UP> mtu 65536 qdisc noqueue state UNKNOWN group default qlen 1000',
            '    link/loopback 00:00:00:00:00:00 brd 00:00:00:00:00:00',
            '    inet 127.0.0.1/8 scope host lo',
            '       valid_lft forever preferred_lft forever',
        ];

        $ec = new ExecutableCommand('ip', ['a', 'address']);
        $result = $ec->exec('a');
        $this->assertArraySubset($correctResultSubset, $result);
        $result = $ec->exec('address');
        $this->assertArraySubset($correctResultSubset, $result);
    }

    public function testCorrectCase_withOption()
    {
        $correctResult = [
            'whoami (GNU coreutils) 8.30',
            'Copyright (C) 2018 Free Software Foundation, Inc.',
            'License GPLv3+: GNU GPL version 3 or later <https://gnu.org/licenses/gpl.html>.',
            'This is free software: you are free to change and redistribute it.',
            'There is NO WARRANTY, to the extent permitted by law.',
            '',
            'Written by Richard Mlynarik.',
        ];

        $ec = new ExecutableCommand('whoami', null, ['--version']);
        $result = $ec->exec(null, '--version');
        $this->assertEquals($correctResult, $result);
    }

    public function testBadCase()
    {
        $this->expectException(\InvalidArgumentException::class);
        $ec = new ExecutableCommand('uname');
    }

    public function testBadCase_bash()
    {
        $this->expectException(\InvalidArgumentException::class);
        $ec = new ExecutableCommand('bash');
    }

    public function testBadCase_exec()
    {
        $this->expectException(\InvalidArgumentException::class);
        $ec = new ExecutableCommand('exec');
    }

    public function testBadCase_withOption()
    {
        $ec = new ExecutableCommand('whoami', null, ['--version']);
        $result = $ec->exec(null, '--help');
        $this->assertFalse($result);
    }

    public function testBadCase_withSubCommand()
    {
        $ec = new ExecutableCommand('ip', ['a', 'address']);
        $result = $ec->exec('r');
        $this->assertFalse($result);
    }
}
