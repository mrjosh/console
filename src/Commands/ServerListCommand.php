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
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ServerListCommand extends ServerCommand
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

        $servers = $this->model->all();

        if ($servers->count() > 0) {

            (new Table($output))->setHeaders(['Id', 'Name', 'Ip address', 'Last connect'])
                ->setRows(json_decode($servers->toJson(), true))
                ->render();
        } else {

            $command->line("No server added to the list. use [ server:add ] to add one.");
        }
    }
}
