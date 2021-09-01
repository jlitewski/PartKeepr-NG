<?php
namespace App\Entity\Auth;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Core\PKNGEntity;
use App\Util\Annotation\TargetService;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity
 * @ORM\Table(
 *      name="UserProvider",
 *      uniqueConstraints={@ORM\UniqueConstraint(name="type", columns={"type"})})
 * @TargetService(uri="/api/user_providers")
 */
class UserProvider extends PKNGEntity {
    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"default"})
     *
     * @var string
     */
    private $type;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"default"})
     *
     * @var bool
     */
    private $editable;

    public function __construct() {
        $this->setEditable(true);
    }

    /**
     * @return bool
     */
    public function isEditable(): bool {
        return $this->editable;
    }

    /**
     * @param bool $editable
     */
    public function setEditable(bool $editable): self {
        $this->editable = $editable;

        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): self {
        $this->type = $type;

        return $this;
    }

    public function Validate() {
        
    }

}