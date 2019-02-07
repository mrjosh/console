<?php

/**
 * Server list
 *
 * @author Alireza Josheghani <josheghani.dev@gmail.com>
 * @since  29 Sep 2018
 */

namespace Josh\Console\Commands;

use Josh\Console\Models\Server;
use Josh\Json\Database\Database;
use Josh\Json\Database\Driver\JsonDriver;
use Symfony\Component\Console\Command\Command;

class ServerCommand extends Command
{
    /**
     * Server model instance
     *
     * @var Server
     */
    protected $model;

    /**
     * ServerCommand constructor.
     *
     * @param string|null $name
     */
    public function __construct(string $name = null)
    {
        parent::__construct($name);
        Database::setDriver(new JsonDriver(base_path("/servers.json")));
        $this->model = new Server();
    }
}
