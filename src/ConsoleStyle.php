<?php

/**
 * Josh Console style
 *
 * @author Alireza Josheghani <josheghani.dev@gmail.com>
 * @since  17 Nov 2016
 */

namespace Josh\Console;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle as Style;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

class ConsoleStyle extends SymfonyCommand
{
    protected $verbosity = OutputInterface::VERBOSITY_NORMAL;

    protected $verbosityMap = [
        'v'      => OutputInterface::VERBOSITY_VERBOSE,
        'vv'     => OutputInterface::VERBOSITY_VERY_VERBOSE,
        'vvv'    => OutputInterface::VERBOSITY_DEBUG,
        'quiet'  => OutputInterface::VERBOSITY_QUIET,
        'normal' => OutputInterface::VERBOSITY_NORMAL,
    ];

    protected $output;

    protected $input;

    /**
     * ConsoleStyle constructor.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    public function __construct(InputInterface $input, OutputInterface $output)
    {
        parent::__construct('Josh Console');

        $this->input = $input;

        $this->output = new Style($input, $output);
    }

    /**
     * Write a string as information output.
     *
     * @param  string          $string
     * @param  null|int|string $verbosity
     * @return void
     */
    public function info($string, $verbosity = null)
    {
        $this->line($string, 'info', $verbosity);
    }

    /**
     * Write a string as warning output.
     *
     * @param  string $string
     * @return void
     */
    public function note($string)
    {
        $this->output->note($string);
    }

    /**
     * Write a string as error output.
     *
     * @param  string          $string
     * @param  null|int|string $verbosity
     * @return void
     */
    public function error($string, $verbosity = null)
    {
        $this->line($string, 'error', $verbosity);
    }

    /**
     * Write a string as standard output.
     *
     * @param  string          $string
     * @param  string          $style
     * @param  null|int|string $verbosity
     * @return void
     */
    public function line($string, $style = null, $verbosity = null)
    {
        $styled = $style ? "<$style>$string</$style>" : $string;

        $this->output->writeln($styled, $this->parseVerbosity($verbosity));
    }

    /**
     * Write a block string as green output.
     *
     * @param  string $message
     */
    public function success($message)
    {
        $this->output->success($message);
    }

    /**
     * Get the verbosity level in terms of Symfony's OutputInterface level.
     *
     * @param  string|int $level
     * @return int
     */
    protected function parseVerbosity($level = null)
    {
        if (isset($this->verbosityMap[$level])) {
            $level = $this->verbosityMap[$level];
        } elseif (! is_int($level)) {
            $level = $this->verbosity;
        }

        return $level;
    }

    public function addInput($message)
    {
        $this->info('>>> ' . $message . ' :');

        $userHandle = fopen("php://stdin", "r");

        $input = fgets($userHandle);

        fclose($userHandle);

        return trim($input);
    }

}
