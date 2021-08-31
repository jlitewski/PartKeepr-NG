<?php
namespace App\Entity\Files;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Files\FileEntity;
use App\Exception\Files\InvalidImageTypeException;
use App\Util\Enums\ImageType;

/**
 * This is only a storage class; actual image rendering is done by the ImageRenderer.
 *
 * @ORM\MappedSuperclass
 */
abstract class Image extends FileEntity {
    public function __construct($type = null) {
        if(ImageType::isValidName($type)) {
            $this->setType($type);
        } else {
            throw new InvalidImageTypeException($type." isn't a valid Image Type!");
        }

        parent::__construct();
    }
}