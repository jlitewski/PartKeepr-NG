<?php
namespace App\Entity\Parts;

use App\Entity\Core\PKNGEntity;
use App\Util\Annotation\TargetService;
use Doctrine\ORM\Mapping as ORM;

/**
 * Represents a part in the database. The heart of our project. Handle with care!
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @TargetService(uri="/api/parts")
 */
class Part extends PKNGEntity {


    public function Validate() {

    }
}