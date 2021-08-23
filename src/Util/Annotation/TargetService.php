<?php
namespace App\Util\Annotation;

use Doctrine\ORM\Mapping\Annotation;

/**
 * @Annotation
 * @Target("CLASS")
 */
final class TargetService implements Annotation {
    /**
     * @var string $uri
     */
    public string $uri;
}