<?php

/**
 * @author : Alireza Josheghani <josheghani.dev@gmail.com>
 * @package : Josh console component
 * @version : 1.1.2
 */

namespace Josh;
use Symfony\Component\Console\Application;

class Console
{

    // instance of the SymfonyApplication
    protected $app;

    /**
     * Console constructor.
     */
    public function __construct()
    {
        $this->app = new Application('Josh console component',1.1);

        $commands = [
            \Josh\Commands\HookSetupCommand::class,
            \Josh\Commands\ChmodCommandLocally::class,
            \Josh\Commands\ChmodCommandHostly::class,
            \Josh\Commands\LampCommand::class,
            \Josh\Commands\LocallyIpCommand::class,
            \Josh\Commands\PublicIpCommand::class,
        ];

        foreach ($commands as $command)
            $this->app->add(new $command);
    }

    /**
     * @return void
     * Register all commands
     */
    public function start()
    {
        $this->app->run();
    }
}

