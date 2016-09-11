<?php

/**
 * @author Alireza Josheghani <josheghani.dev@gmail.com>
 * @version 1.1
 * @package Lemax Console | LocallyIpCommand
 */

namespace Josh\Commands;
use Josh\ConsoleStyle as Style;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class LocallyIpCommand extends Command {

    public function configure()
    {
        $this->setName('ip:locally')
            ->setDescription('Show the locally ip address');
    }

    protected function execute(InputInterface $input , OutputInterface $output)
    {
        $command = new Style($input,$output);
        $command->info("Locally Ip Address : ".exec("ifconfig | grep -Eo 'inet (addr:)?([0-9]*\.){3}[0-9]*' | grep -Eo '([0-9]*\.){3}[0-9]*' | grep -v '127.0.0.1'"));
    }

}
