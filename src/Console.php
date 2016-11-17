<?php

/**
 * Josh console component
 *
 * @author : Alireza Josheghani <josheghani.dev@gmail.com>
 * @since  17 Nov 2016
 */

namespace Josh\Console;

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
            \Josh\Console\Commands\HookSetupCommand::class,
            \Josh\Console\Commands\ChmodCommandLocally::class,
            \Josh\Console\Commands\ChmodCommandHostly::class,
            \Josh\Console\Commands\LampCommand::class,
            \Josh\Console\Commands\LocallyIpCommand::class,
            \Josh\Console\Commands\PublicIpCommand::class,
        ];

        foreach ($commands as $command) {
            $this->add(new $command);
        }
    }

    /**
     * Register all commands
     *
     * @return object
     */
    public function start()
    {
        return $this->run();
    }
}

