<?php

/**
 * Public ip command
 *
 * @author Alireza Josheghani <josheghani.dev@gmail.com>
 * @since  17 Nov 2016
 */

namespace Josh\Console\Commands;

use Josh\Console\ConsoleStyle as Style;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class PublicIpCommand extends Command
{

    public function configure()
    {
        $this->setName('ip:public')
            ->setDescription('Show the public ip address');
    }

    protected function execute(InputInterface $input , OutputInterface $output)
    {
        $command = new Style($input, $output);

        $command->info(
            "Public Ip Address : ".
            trim(file_get_contents('http://ipinfo.io/ip'))
        );
    }

}