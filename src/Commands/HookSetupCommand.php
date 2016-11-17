<?php

/**
 * Packagist hook setup
 *
 * @author Alireza Josheghani <josheghani.dev@gmail.com>
 * @since  17 Nov 2016
 */

namespace Josh\Console\Commands;

use GuzzleHttp\Client as Guzzle;
use Josh\Console\ConsoleStyle as Style;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;


class HookSetupCommand extends Command
{

    /**
     * configure command
     *
     * @return void
     */
    public function configure()
    {
        $this->setName('hook:setup')
            ->setDescription('Setup hook of your packagist package');

        $this->addOption('clear' , 'c', InputOption::VALUE_NONE, 'Clear default details');
    }

    /**
     * execute command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input , OutputInterface $output)
    {
        $authFile = $_SERVER['HOME'] . '/.Josh/auth.json';

        if($input->getOption('clear')){
            unlink($authFile);
        }

        $command = new Style($input, $output);

        if(! file_exists($authFile)){

            $username = $command->addInput('Enter your packagist username');

            if(empty($username)) {
                $command->error("Packagist username is required !");
                exit;
            }

            $api = $command->addInput('Enter your packagist API');

            if(empty($api)) {
                $command->error("Packagist API is required !");
                exit;
            }

            $helper = $this->getHelper('question');

            $question = new ConfirmationQuestion(
                'Are you wanna to save this details of default ? [ Yes or No ] :',
                ['yes' , 'no']
            );

            $answer = $helper->ask($input, $output, $question);

            if($answer){
                file_put_contents($authFile,json_encode([
                    'api' => $api,
                    'username' => $username
                ]));
            }

        } else {

            $auth = file_get_contents($authFile);

            $auth = json_decode($auth, true);

            $command->line("");

            $command->line("Packagist API : ". $auth['api']);

            $command->line('Packagist Username : '. $auth['username']);

            $command->note(
                'If you want change your details type `josh hook:setup --clear` '
            );

            $api = $auth['api'];

            $username = $auth['username'];
        }

        $this->sendRequest($command,$api,$username);
    }

    /**
     * Send Request to packagist
     *
     * @param Style $command
     * @param $api
     * @param $username
     */
    public function sendRequest(Style $command, $api, $username)
    {
        $package = $command->addInput('Enter your package-url');

        if(empty(trim($package))) {
            $command->error("Package-url is required !");
            exit;
        }

        $command->info("Sending request ...");

        $data = [ 'repository' => [ 'url' => $package ] ];

        $client = new Guzzle([
            'base_uri' => 'https://packagist.org/',
            'headers' => [
                'Accept' => 'application/json'
            ]
        ]);

        $result = $client->post('/api/update-package?username=' . $username .
            '&apiToken=' . $api,[ 'json' => $data ]);

        $result = json_decode($result->getBody()->getContents(), true);

        if($result['status'] !== 'success') {
            $command->error("Message : ".$result['message']." | Failed ");
            exit;
        }

        $command->info("Success");
    }

}