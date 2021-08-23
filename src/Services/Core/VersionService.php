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
    /**
     * Extracts the current commit from GIT.
     * 
     * @param bool $short If we should pass '--short' to the command
     * @return string The result of the command
     */
    public function extractGITCommit(bool $short = false): string {
        $cmd = "git rev-parse ";
        if($short) { $cmd .= "--short "; }
        $cmd .= "HEAD";

        return trim(shell_exec($cmd));
    }

    /**
     * Sets the version string. Replaces the default set in services.yaml (app.version)
     * 
     * @param string $version The version string to replace the default one with
     * @return self
     */
    public function setVersion(string $version): self {
        $this->version = $version;
        return $this;
    }

    /**
     * 
     */
    public function getVersion(): string {
        return $this->version;
    }

    /**
     * 
     */
    public function setVersionURI(string $versionURI): self {
        $this->versionURI = $versionURI;
        return $this;
    }

    /**
     * 
     */
    public function getCanonicalVersion(): string {
        if($this->version === 'V_GIT') {
            return 'GIT development version Commit '.$this->extractGITCommit()." Short Commit ".$this->extractGITCommit(true);
        } else {
            return $this->version;
        }
    }

    /**
     * 
     */
    public function doVersionCheck(): void {
        //TODO: Flesh out the logic in this once we have a need for an updater
    }

    /**
     * 
     */
    public function getLatestVersion(): mixed {
        //TODO: Flesh out the logic in this once we have a need for an updater
        return false; //XXX: Fail fast
    }
}