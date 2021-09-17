<?php
namespace App\Util\Traits;

use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * This Trait is used as a single entry point to access the Symfony Translator Service
 * throughout the app without needing to inject TranslatorInterface into every class that
 * needs access to it. It builds on top of the idea that PartKeepr had for translatable
 * Exceptions, but was never really implemented.
 * 
 * Note, this is done purely out of sheer laziness and the want to keep the code as 
 * readable as possible.
 * 
 * @author Jacob Litewski
 */
trait TranslationTrait {

    /**
     * The Symfony Translator
     * 
     * @var TranslatorInterface
     */
    private TranslatorInterface $translator;

    /**
     * Injects the TranslatorInterface into the Trait via Symfony Autowiring
     * 
     * @required
     * @param TranslatorInterface $translator 
     * @return void
     * @internal This shouldn't be called ANYWHERE in code. This is ONLY for autowiring
     */
    public final function autowire(TranslatorInterface $translator): void {
        $this->translator = $translator;
    }

    /**
     * Returns the Translator
     * 
     * @return TranslatorInterface 
     */
    protected final function getTranslator(): TranslatorInterface {
        return $this->translator;
    }

}