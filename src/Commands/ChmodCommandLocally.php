<?php

/**
 * Chmod command locally
 *
 * @author Alireza Josheghani <josheghani.dev@gmail.com>
 * @since  17 Nov 2016
 */

namespace Josh\Console\Commands;

use Josh\Console\ConsoleStyle as Style;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class ChmodCommandLocally extends Command
{

    public function configure()
    {
        $this->setName('chmod:locally')
            ->setDescription('Configuring permissions of your project for localy');

        $this->addArgument('directory', InputArgument::REQUIRED, 'Get the directory');
    }

    protected function execute(InputInterface $input , OutputInterface $output)
    {
        $command = new Style($input, $output);

        $dir = $input->getArgument('directory');

        exec('sudo find '.$dir.' -type d -exec chmod 777 {} +');

        exec('sudo find '.$dir.' -type f -exec chmod 666 {} +');

        $command->info("Success");
    }

}
