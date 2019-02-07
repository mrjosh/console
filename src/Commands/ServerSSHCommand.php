<?php

/**
 * Ssh to server
 *
 * @author Alireza Josheghani <josheghani.dev@gmail.com>
 * @since  29 Sep 2018
 */

namespace Josh\Console\Commands;

use Josh\Console\ConsoleStyle as Style;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ServerSSHCommand extends ServerCommand
{

    /**
     * configure command
     *
     * @return void
     */
    public function configure()
    {
        $this->setName('server:ssh')
            ->setDescription('ssh to the server');

        $this->addArgument('server', InputArgument::REQUIRED, "Server id or name");
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

        $serverIdOrName = $input->getArgument('server');

        if ($servers->count() > 0) {

            $server = $this->model->findBy("name", $serverIdOrName);

            $server = ( $server->exists() ? $server : $this->model->findBy("id", $serverIdOrName) );

            $ip = $server->getAttribute("ip");

            $command->info("Connecting to [$ip]...");

            echo system("ssh root@$ip");

        } else {

            $command->line("No server added to the list. use [ server:add ] to add one.");
        }
    }

    /** Get home directory
     *
     * @return array
     */
    public function getHomeDir()
    {
        if(empty($_SERVER['HOME'])){
            return posix_getpwuid(posix_getuid());
        }

        return $_SERVER['HOME'];
    }
}
