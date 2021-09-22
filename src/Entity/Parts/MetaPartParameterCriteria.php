<?php
namespace App\Entity\Parts;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Core\PKNGEntity;
use App\Entity\Units\Unit;
use App\Entity\Units\SiPrefix;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity()
 */
class MetaPartParameterCriteria extends PKNGEntity {
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Parts\Part", inversedBy="metaPartParameterCriterias")
     *
     * @var App\Entity\Parts\Part
     */
    private $part;

    /**
     * @ORM\Column(type="string")
     * @Groups({"default"})
     *
     * @var string
     */
    private $partParameterName;

    /**
     * @ORM\Column(type="string")
     * @Groups({"default"})
     *
     * @var string
     */
    private $operator;

    /**
     * @ORM\Column(type="float",nullable=true)
     * @Groups({"default"})
     *
     * @var float
     */
    private $value;

    /**
     * @ORM\Column(type="float",nullable=true)
     *
     * @var float
     */
    private $normalizedValue;

    /**
     * The SiPrefix of the unit.
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Units\SiPrefix")
     * @Groups({"default"})
     *
     * @var SiPrefix
     */
    private $siPrefix;

    /**
     * @ORM\Column(type="string")
     * @Groups({"default"})
     *
     * @var string
     */
    private $stringValue;

    /**
     * The type of the value.
     *
     * @ORM\Column(type="string")
     * @Groups({"default"})
     *
     * @var string
     */
    private $valueType;

    /**
     * The unit for this type. May be null.
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Units\Unit")
     * @Groups({"default"})
     *
     * @var App\Entity\Units\Unit
     */
    private $unit;

    /**
     * Get the value of part
     */
    public function getPart()
    {
        return $this->part;
    }

    /**
     * Set the value of part
     */
    public function setPart(Part $part = null): self {
        $this->part = $part;

        return $this;
    }
}