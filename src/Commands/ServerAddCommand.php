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

        if (! file_exists($file = $this->getHomeDir() . "/.Josh/servers.json")) {

            if (! is_dir($dir = $this->getHomeDir() . "/.Josh")) {
                mkdir($dir,0777);
            }

            touch($file);
            chmod($file,0777);
            file_put_contents($file,json_encode([]));
        }

        $servers = json_decode(file_get_contents($file), true);

        $ip = $input->getOption('ip');
        $name = $input->getOption('name');

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

        if(count($servers) == 0){
            $id = 1;
        } else {
            $id = array_reverse($servers)[0][0] + 1;
        }

        var_dump($id);

        $servers[] = [ $id, $name, $ip, null ];

        file_put_contents($file,json_encode($servers));

        $command->info("Server {$name} added successfully.");
        exit;
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
