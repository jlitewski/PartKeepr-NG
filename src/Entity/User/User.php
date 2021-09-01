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
    /**
     * @ORM\Column(length=50)
     * @Groups({"default"})
     */
    private $username;

    /**
     * @Groups({"default"})
     * @ORM\Column(length=32,nullable=true)
     */
    private $password;

    /**
     * @Groups({"default"})
     * @VirtualField(type="string")
     *
     * @var string
     */
    private $newPassword;

    /**
     * @Groups({"default"})
     * @ORM\Column(length=255,nullable=true)
     *
     * @var string
     */
    private $email;

    /**
     * @ORM\Column(type="boolean")
     */
    private $admin;

    /**
     * Marks a user as a legacy user (=old md5 auth).
     *
     * @ORM\Column(type="boolean")
     * @Groups({"default"})
     *
     * @var bool
     */
    private $legacy;

    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    private $lastSeen;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Auth\UserProvider")
     * @Groups({"default"})
     */
    private $provider;

    public function Validate() { }

    public function getRoles() { }

    public function getPassword() { }

    public function getSalt() { }

    public function getUsername() { }

    public function eraseCredentials() { }

    public function isEqualTo(UserInterface $user) { }
    
}
