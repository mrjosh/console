<?php

/**
 * Josh console component unit test
 *
 * @author Alireza Josheghani <josheghani.dev@gmail.com>
 * @since  17 Nov 2016
 */

use Josh\Console\Console;

class JoshConsoleTest extends PHPUnit_Framework_TestCase
{
    /**
     * Instatce of console component
     *
     * @var object
     */
    protected $console;

    /**
     * Command name
     *
     * @var string
     */
    protected $command = null;

    /**
     * JoshConsoleTest constructor.
     *
     * @author Alireza Josheghani <josheghani.dev@gmail.com>
     * @since  17 Nov 2016
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->console = new Console;
    }

    /**
     * HookSetup command test
     *
     * @author Alireza Josheghani <josheghani.dev@gmail.com>
     * @since  17 Nov 2016
     */
    public function testHookSetupCommand()
    {
        $this->command = 'hook:setup';

        $commandName = $this->console->get($this->command)->getName();

        $this->assertEquals($this->command, $commandName);

        $this->assertNotEquals('setup:hook', $commandName);
    }
}