<?php
namespace App\Util\Annotation;

use Doctrine\ORM\Mapping\Annotation;

/**
 * @Annotation
 * @Target("PROPERTY")
 */
final class VirtualField implements Annotation {
    /**
     * @var string
     */
    public $type;
}