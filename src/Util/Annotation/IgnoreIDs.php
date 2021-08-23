<?php
namespace App\Util\Annotation;

use Doctrine\ORM\Mapping\Annotation;

/**
 * @Annotation
 * @Target("CLASS")
 */
final class IgnoreIDs implements Annotation { }
