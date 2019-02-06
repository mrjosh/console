<?php

/**
 * Add server
 *
 * @author Alireza Josheghani <josheghani.dev@gmail.com>
 * @since  29 Sep 2018
 */

namespace Josh\Console\Commands;

use Josh\Console\ConsoleStyle as Style;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ServerAddCommand extends Command
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

        if (! file_exists($file = package_path("servers.json"))) {

            if (! is_dir($dir = package_path())) {
                mkdir($dir,0777);
            }

            touch($file);
            chmod($file,0777);
            file_put_contents($file,json_encode([]));
        }

        $servers = json_decode(file_get_contents($file), true);

        $ip = $input->getOption('ip');
        $name = $input->getOption('name');

        if (empty($name) || empty($ip)){

            $command->error("Server name and ip address is required. use [server:add --ip=***.***.*** --name=example]");
        } else {

            foreach ($servers as $server){
                if ( $server[1] == $name ) {
                    $command->error("Server {$name} already exists.");
                    exit;
                }

                if ( $server[2] == $ip ) {
                    $command->error("Server IP {$ip} already exists.");
                    exit;
                }
            }

            $id = ( count($servers) == 0 ? 1 : array_reverse($servers)[0][0] + 1 );

            $servers[] = [ $id, $name, $ip, null ];

            file_put_contents($file,json_encode($servers));

            $command->info("Server {$name} added successfully.");
        }
        exit;
    }
}
