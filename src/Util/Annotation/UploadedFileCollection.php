<?php
namespace App\Util\Annotation;

use Doctrine\ORM\Mapping\Annotation;

/**
 * Use this annotation on any property to replace any temporary images with
 * their concrete implementation.
 * 
 * @Annotation
 * @Target("PROPERTY")
 */
final class UploadedFileCollection implements Annotation { }