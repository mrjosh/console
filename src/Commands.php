<?php

/**
 * @author Alireza Josheghani <josheghani.dev@gmail.com>
 * @version 1.1
 * @package Josh Console | Commands
 * This file just for register Josh-commands
 */

return array(

    // Josh Hook Setup Command
    \Josh\Commands\HookSetupCommand::class,

    // Josh Chmod Command Localy
    \Josh\Commands\ChmodCommandLocaly::class,

    // Josh Chmod Command Hostly
    \Josh\Commands\ChmodCommandHostly::class,

    // Lamp Command
    \Josh\Commands\LampCommand::class,

    // Localy Ip Command
    \Josh\Commands\LocalyIpCommand::class,

    // Public Ip Command
    \Josh\Commands\PublicIpCommand::class,

);