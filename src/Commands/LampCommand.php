<?php

/**
 * Lamp Command
 *
 * @author Alireza Josheghani <josheghani.dev@gmail.com>
 * @since  17 Nov 2016
 */

namespace Josh\Console\Commands;
use Josh\Console\ConsoleStyle as Style;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class LampCommand extends Command
{

    public function configure()
    {
        $this->setName('lamp')
            ->setDescription('Start the lamp services - [ Just for Linux ]');
    }

    protected function execute(InputInterface $input , OutputInterface $output)
    {
        $command = new Style($input, $output);

        $command->info(exec("sudo /opt/opt/lamp start"));
    }

}