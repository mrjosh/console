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
     * Ip Command unit test
     *
     * @author Alireza Josheghani <josheghani.dev@gmail.com>
     * @since  17 Nov 2016
     */
    public function testIpCommands()
    {
        $this->command = 'ip:locally';

        $commandName = $this->console->get($this->command)->getName();

        $this->assertEquals($this->command, $commandName);

        $this->assertNotEquals('ip:public', $commandName);

        $this->command = 'ip:public';

        $commandName = $this->console->get($this->command)->getName();

        $this->assertEquals($this->command, $commandName);

        $this->assertNotEquals('ip:locally', $commandName);
    }

    /**
     * Lamp command test
     *
     * @author Alireza Josheghani <josheghani.dev@gmail.com>
     * @since  17 Nov 2016
     */
    public function testLampCommand()
    {
        $this->command = 'lamp';

        $commandName = $this->console->get($this->command)->getName();

        $this->assertEquals($this->command, $commandName);

        $this->assertNotEquals('xampp', $commandName);
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

    /**
     * Chmod locally command test
     *
     * @author Alireza Josheghani <josheghani.dev@gmail.com>
     * @since  17 Nov 2016
     */
    public function testChmoodLocallyCommand()
    {
        $this->command = 'chmod:locally';

        $commandName = $this->console->get($this->command)->getName();

        $this->assertEquals($this->command, $commandName);

        $this->assertNotEquals('chmod:hostly', $commandName);
    }

    /**
     * Chmod hostly command
     *
     * @author Alireza Josheghani <josheghani.dev@gmail.com>
     * @since  17 Nov 2016
     */
    public function testChmoodHostlyCommand()
    {
        $this->command = 'chmod:hostly';

        $commandName = $this->console->get($this->command)->getName();

        $this->assertEquals($this->command, $commandName);

        $this->assertNotEquals('chmod:locally', $commandName);
    }
}