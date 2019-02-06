<?php

/**
 * Josh console component
 *
 * @author : Alireza Josheghani <josheghani.dev@gmail.com>
 * @since  17 Nov 2016
 */

namespace Josh\Console;

use Symfony\Component\Console\Application;
use Josh\Console\Commands\HookSetupCommand;
use Josh\Console\Commands\ServerSSHCommand;
use Josh\Console\Commands\ServerAddCommand;
use Josh\Console\Commands\ServerListCommand;

class Console extends Application
{
    /**
     * Commands
     *
     * @var array
     */
    protected $commands = [
        HookSetupCommand::class,
        ServerListCommand::class,
        ServerAddCommand::class,
        ServerSSHCommand::class
    ];

    /**
     * Console constructor.
     * Register the commands
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct('Josh console component', '0.0.1');

        foreach ($this->commands as $command) {
            $this->add(new $command);
        }
    }

    /**
     * Run the console
     *
     * @return void
     */
    public function start()
    {
        try {

            $this->run();
        } catch (\Exception $e){}
    }
}

