<?php

/**
 * Server list
 *
 * @author Alireza Josheghani <josheghani.dev@gmail.com>
 * @since  29 Sep 2018
 */

namespace Josh\Console\Commands;

use Josh\Console\ConsoleStyle as Style;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ServerListCommand extends Command
{

    /**
     * configure command
     *
     * @return void
     */
    public function configure()
    {
        $this->setName('server:list')
            ->setDescription('servers list');
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

        if (count($servers) == 0) {

            $command->line("No server added to the list. use [ server:add ] to add one.");
        } else {

            $table = new Table($output);

            $table->setHeaders(['Id', 'Name', 'Ip address', 'Last connect'])
                ->setRows($servers)
                ->render();
        }
    }
}
