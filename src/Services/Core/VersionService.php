<?php
namespace App\Services\Core;

use Symfony\Contracts\Translation\TranslatorInterface;

//TODO: This needs to have RemoteFileLoader working before it can be finished
//TODO: Flesh out the PHPDocs for everything

class VersionService {
    /**
     * 
     */
    private SystemNoticeService $systemNotice;

    /**
     * 
     */
    private string $versionURI;

    /**
     * 
     */
    private TranslatorInterface $translator;

    /**
     * 
     */
    private string $version;

    /**
     * 
     */
    //private RemoteFileLoaderFactory remoteFileLoader;

    //TODO: Add in the RemoteFileLoader into the Constructor
    public function __construct($version, SystemNoticeService $notice, TranslatorInterface $translator) /**RemoteFileLoaderFactory $remoteFileLoader)*/{
        $this->systemNotice = $notice;
        $this->translator = $translator;
        //$this->remoteFileLoader = $remoteFileLoader;

        //This is autowired and reflects %app.version% in services.yaml or services_dev.yaml
        $this->version = $version;
    }

    //TODO: Implement the functions this class needs to function
}