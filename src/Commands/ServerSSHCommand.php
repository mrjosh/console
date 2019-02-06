<?php

/**
 * Ssh to server
 *
 * @author Alireza Josheghani <josheghani.dev@gmail.com>
 * @since  29 Sep 2018
 */

namespace Josh\Console\Commands;

use Josh\Console\ConsoleStyle as Style;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ServerSSHCommand extends Command
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

        if(file_exists($file = $this->getHomeDir() . "/.Josh/servers.json")){

            $servers = json_decode(file_get_contents($file), true);
            $serverIdOrName = $input->getArgument('server');

            if (count($servers) == 0) {

                $command->line("No server added to the list. use [ server:add ] to add one.");
            }

            $currentServer = [];

            foreach ($servers as $server){

                if ($server[0] == $serverIdOrName){
                    $currentServer = $server;
                } else if ($server[1] == $serverIdOrName){
                    $currentServer = $server;
                }
            }

            $command->info("Connecting to [$currentServer[1]]...");

            system("ssh root@$currentServer[2]");

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
