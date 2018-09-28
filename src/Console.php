<?php

/**
 * Josh console component
 *
 * @author : Alireza Josheghani <josheghani.dev@gmail.com>
 * @since  17 Nov 2016
 */

namespace Josh\Console;

use Josh\Console\Commands\HookSetupCommand;
use Josh\Console\Commands\ServerAddCommand;
use Josh\Console\Commands\ServerListCommand;
use Josh\Console\Commands\ServerSSHCommand;
use Symfony\Component\Console\Application;

class Console extends Application
{

    /**
     * Console constructor.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct('Josh console component', '0.0.1');

        $commands = [
            HookSetupCommand::class,
            ServerListCommand::class,
            ServerAddCommand::class,
            ServerSSHCommand::class
        ];

        foreach ($commands as $command) {
            $this->add(new $command);
        }
    }

    /**
     * Register all commands
     *
     * @return int
     * @throws \Exception
     */
    public function start()
    {
        return $this->run();
    }
}

