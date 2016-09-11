<?php

/**
 * @author Alireza Josheghani <josheghani.dev@gmail.com>
 * @version 1.1
 * @package Lemax Console | Lamp Command => Just for linux
 */

namespace Josh\Commands;
use Josh\ConsoleStyle as Style;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class LampCommand extends Command {

    public function configure()
    {
        $this->setName('lamp')
            ->setDescription('Start the lamp services - [ Just for Linux ]');
    }

    protected function execute(InputInterface $input , OutputInterface $output)
    {
        $command = new Style($input,$output);
        $command->info(exec("sudo /opt/opt/lamp start"));
    }

}