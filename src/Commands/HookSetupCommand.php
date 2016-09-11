<?php

/**
 * @author Alireza Josheghani <josheghani.dev@gmail.com>
 * @version 1.1
 * @package Lemax Console | Packagist hook setup
 */

namespace Josh\Commands;
use Josh\Libs\iBrowse;
use Josh\ConsoleStyle as Style;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class HookSetupCommand extends Command {

    use iBrowse;

    public function configure()
    {
        $this->setName('hook:setup')->setDescription('Setup hook of your packagist package');
    }

    protected function execute(InputInterface $input , OutputInterface $output)
    {
        $command = new Style($input,$output);

        $username = $command->addInput('Enter your packagist username');
        if(empty(trim($username))) {
            $command->error("Packagist username is required !");
            exit;
        }

        $api = $command->addInput('Enter your packagist API');
        if(empty(trim($api))){
            $command->error("Packagist API is required !");
            exit;
        }

        $package = $command->addInput('Enter your package-url');
        if(empty(trim($package))){
            $command->error("Package-url is required !");
            exit;
        }

        $command->info("Sending request ...");

        $data = array('repository' => array('url' => trim($package)));
        $data_string = json_encode($data);
        $result = $this->data(array(
            'username' => $username,
            'token' => $api,
            'data' => $data_string
        ))->post();

        if($result['status'] !== 'success'){
            $command->error("Message : ".$result['message']." | Failed ");
            exit;
        }

        $command->info("Success");
    }

}