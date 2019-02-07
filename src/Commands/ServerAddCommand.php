<?php

/**
 * Add server
 *
 * @author Alireza Josheghani <josheghani.dev@gmail.com>
 * @since  29 Sep 2018
 */

namespace Josh\Console\Commands;

use Josh\Console\ConsoleStyle as Style;
use Josh\Console\Models\Server;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ServerAddCommand extends ServerCommand
{
    /**
     * configure command
     *
     * @return void
     */
    public function configure()
    {
        $this->setName('server:add')
            ->setDescription('Add server');

        $this->addOption('name', 'e', InputOption::VALUE_REQUIRED, 'Server name');

        $this->addOption('ip', 'i',  InputOption::VALUE_REQUIRED, 'Server ip address');
    }

    /**
     * execute command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input , OutputInterface $output)
    {
        $command = new Style($input, $output);

        $servers = $this->model->all();

        $ip = $input->getOption('ip');
        $name = $input->getOption('name');

        if (empty($name) || empty($ip)){

            $command->error("Server name and ip address is required. use [server:add --ip=***.***.*** --name=example]");
        } else {

            /** @var Server $server */
            foreach ($servers as $server){
                if ( $server->getAttribute("name") == $name ) {
                    $command->error("Server {$name} already exists.");
                    exit;
                }

                if ( $server->getAttribute("ip") == $ip ) {
                    $command->error("Server IP {$ip} already exists.");
                    exit;
                }
            }

            $id = ( $servers->count() == 0 ? 1 : array_reverse($servers->toArray())[0]->id + 1 );

            $this->model->create(compact("id", "ip", "name"));

            $command->info("Server {$name} added successfully.");
        }
        exit;
    }
}
