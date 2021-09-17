<?php
namespace App\Util\Annotation;

use Doctrine\ORM\Mapping\Annotation;

/**
 * This Annotation is left over code from OG PartKeepr from the move over to the new platform. This
 * doesn't do what it was originally designed to do anymore, and as such isn't needed anymore. It will
 * be removed before the PKNG 1.0 release, and is only here until the API stuff is implemented
 * 
 * @Annotation
 * @Target("CLASS")
 * @deprecated
 */
final class TargetService implements Annotation {
    /**
     * @var string $uri
     */
    public string $uri;
}