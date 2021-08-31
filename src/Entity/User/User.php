<?php
namespace App\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Core\PKNGEntity;
use App\Util\Annotation\TargetService;
use App\Util\Annotation\VirtualField;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity
 * @ORM\Table(
 *      name="PartKeeprUser",
 *      uniqueConstraints={@ORM\UniqueConstraint(name="username_provider", columns={"username", "provider_id"})})
 * @TargetService(uri="/api/users")
 */
class User extends PKNGEntity implements UserInterface, EquatableInterface {
    
}
