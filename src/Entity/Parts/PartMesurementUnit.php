<?php
namespace App\Entity\Parts;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\Core\PKNGEntity;
use App\Util\Annotation\TargetService;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * This entity represents a part measurement unit. Typical measurement units are pieces, centimeters etc.
 *
 * @ORM\Entity
 * @ORM\Table(name="PartUnit")
 * @UniqueEntity("name")
 * @TargetService(uri="/api/part_measurement_units")
 **/
class PartMeasurementUnit extends PKNGEntity {
    /**
     * Defines the name of the unit.
     *
     * @ORM\Column(type="string", unique=true)
     * @Groups({"default"})
     *
     * @Assert\NotNull
     * @var string
     */
    private $name;

    /**
     * Defines the short name of the unit.
     *
     * @ORM\Column(type="string")
     * @Groups({"default"})
     *
     * @Assert\NotNull
     * @var string
     */
    private $shortName;

    /**
     * Defines if the unit is default or not. Note that this property may not be set directly.
     *
     * @ORM\Column(type="boolean", name="is_default")
     * @Groups({"default"})
     *
     * @Assert\NotNull
     * @var bool
     */
    private $default;

    /**
     * The parts used by this PartMeasurementUnit.
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Parts\Part",mappedBy="partUnit")
     * 
     * @var ArrayCollection
     */
    private $parts;

    public function __construct() {
        $this->parts = new ArrayCollection();
        $this->default = false;
    }

    /**
     * Returns the name for this unit.
     *
     * @param none
     *
     * @return string The name for this unit
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * Sets the name for this unit.
     *
     * @param string $name The name for this unit
     * @return self
     */
    public function setName(string $name): self {
        $this->name = $name;
        $this->mark();

        return $this;
    }

    /**
     * Returns the short name for this unit.
     *
     * @param none
     *
     * @return string The short name for this unit
     */
    public function getShortName(): string {
        return $this->shortName;
    }

    /**
     * Sets the short name for this unit.
     *
     * Short names are used for list views (e.g. if your unit name is "metres", your short name could be "m")
     *
     * @param string $shortName The short name
     * @return self
     */
    public function setShortName(string $shortName): self {
        $this->shortName = $shortName;
        $this->mark();

        return $this;
    }

    /**
     * Returns if the unit is default or not.
     *
     * @param none
     *
     * @return bool True if the unit is default, false for not
     */
    public function isDefault(): bool {
        return $this->default;
    }

    /**
     * Defines if the unit is default or not.
     *
     * @param bool $default true if the unit is default, false otherwise
     * @return self
     */
    public function setDefault(bool $default): self {
        $this->default = $default;
        $this->mark();

        return $this;
    }

    /**
     * Returns the parts for this PartUnit
     * 
     * @return ArrayCollection
     */
    public function getParts() {
        return $this->parts->getValues();
    }
}