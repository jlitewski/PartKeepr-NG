<?php
namespace App\Command;

use Symfony\Component\Console\Command\Command;

class PKNGCommand extends Command {

    protected static string $defaultName;

    public function __construct(string $commandName) {
        $this::$defaultName = $commandName;
        
        parent::__construct();
    }
}