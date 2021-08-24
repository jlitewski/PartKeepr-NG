<?php
namespace App\Command\Core;

use Symfony\Component\Console\Command\Command;

class CheckForUpdatesCommand extends Command {

    protected static $defaultName = 'pkng:cron:versioncheck';

    public function configure() {
        $this->setName("pkng:cron:versioncheck");
        $this->setDescription('Checks for PartKeepr-NG updates');
    }
    
}