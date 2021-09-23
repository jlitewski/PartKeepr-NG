<?php
namespace App\Entity\Parts;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Core\PKNGEntity;
use App\Entity\Units\SiPrefix;
use App\Entity\Units\Unit;
use App\Util\Enums\PartParameterValues;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * This object represents a parameter. Each parameter can have an unit (defined by the class "Unit") associated with
 * a numeric value.
 *
 * @ORM\Entity
 * @UniqueEntity("name")
 * @ORM\HasLifecycleCallbacks
 */
class PartParameter extends PKNGEntity {
     /**
     * The part this parameter is bound to
     *
     * @ORM\ManyToOne(
     *      targetEntity="App\Entity\Parts\Part",
     *      inversedBy="parameters"
     * )
     * 
     * @var Part
     */
    private $part;

    /**
     * The name of the parameter (e.g. Resistance, Voltage).
     *
     * @ORM\Column(type="string", unique=true)
     * @Groups({"default"})
     *
     * @Assert\NotNull
     * @var string
     */
    private $name;

    /**
     * A description for this parameter.
     *
     * @ORM\Column(type="string")
     * @Groups({"default"})
     *
     * @Assert\NotNull
     * @var string
     */
    private $description;

    /**
     * The unit for this type. May be null.
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Units\Unit")
     * @Groups({"default"})
     *
     * @Assert\NotBlank(allowNull=true)
     * @var Unit
     */
    private $unit;

    /**
     * The value of the unit. Together with the prefix, it becomes the actual value.
     *
     * Example: If you have 10µ, the value field will contain "10", the prefix object is linked to the SiPrefix
     * representing "µ" and the rawValue field will contain 0.000001
     *
     * @ORM\Column(type="float",nullable=true)
     * @Groups({"default"})
     *
     * @Assert\NotBlank(allowNull=true)
     * @var float
     */
    private $value;

    /**
     * The normalized value (the product of si prefix + value).
     *
     * @ORM\Column(type="float",nullable=true)
     *
     * @Assert\NotBlank(allowNull=true)
     * @var mixed
     */
    private $normalizedValue;

    /**
     * The maximum value of the parameter.
     *
     * @ORM\Column(type="float",name="maximumValue",nullable=true)
     * @Groups({"default"})
     *
     * @Assert\NotBlank(allowNull=true)
     * @var float
     */
    private $maxValue;

    /**
     * The normalized maximum value (the product of si prefix + value).
     *
     * @ORM\Column(type="float",nullable=true)
     *
     * @Assert\NotBlank(allowNull=true)
     * @var mixed
     */
    private $normalizedMaxValue;

    /**
     * The minimum value of the parameter.
     *
     * @ORM\Column(type="float",name="minimumValue",nullable=true)
     * @Groups({"default"})
     *
     * @Assert\NotBlank(allowNull=true)
     * @var float
     */
    private $minValue;

    /**
     * The normalized minimum value (the product of si prefix + value).
     *
     * @ORM\Column(type="float",nullable=true)
     *
     * @Assert\NotBlank(allowNull=true)
     * @var mixed
     */
    private $normalizedMinValue;

    /**
     * The string value if the parameter is a string.
     *
     * @ORM\Column(type="string")
     * @Groups({"default"})
     *
     * @Assert\NotNull
     * @var string
     */
    private $stringValue;

    /**
     * The type of the value.
     *
     * @ORM\Column(type="string")
     * @Groups({"default"})
     *
     * @Assert\NotNull
     * @var string
     */
    private $valueType;

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
     * The SiPrefix of the min value.
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Units\SiPrefix")
     * @Groups({"default"})
     *
     * @var SiPrefix
     */
    private $minSiPrefix;

    /**
     * The SiPrefix of the max value.
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Units\SiPrefix")
     * @Groups({"default"})
     *
     * @var SiPrefix
     */
    private $maxSiPrefix;

    public function __construct() {
        $this->setValueType(PartParameterValues::STR);
        $this->setDescription("");
        $this->setStringValue("");
    }

    /**
     * Get the value of part
     */
    public function getPart(): Part {
        return $this->part;
    }

    /**
     * Set the value of part
     */
    public function setPart(Part $part): self {
        $this->part = $part;
        $this->mark();

        return $this;
    }

    /**
     * Get the value of name
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * Set the value of name
     */
    public function setName(string $name): self {
        $this->name = $name;
        $this->mark();

        return $this;
    }

    /**
     * Get the value of description
     */
    public function getDescription(): string {
        return $this->description;
    }

    /**
     * Set the value of description
     */
    public function setDescription(string $description): self {
        $this->description = $description;
        $this->mark();

        return $this;
    }

    /**
     * Get the value of unit
     */
    public function getUnit(): Unit {
        return $this->unit;
    }

    /**
     * Set the value of unit
     */
    public function setUnit(Unit $unit): self {
        $this->unit = $unit;
        $this->mark();

        return $this;
    }

    /**
     * Get the value of value
     */
    public function getValue(): float {
        return $this->value;
    }

    /**
     * Set the value of value
     */
    public function setValue(float $value): self {
        $this->value = $value;
        $this->setNormalizedValue($this->renormalizeValue($this->siPrefix, $value));

        return $this;
    }

    /**
     * Get the value of normalizedValue
     */
    public function getNormalizedValue(): mixed {
        return $this->normalizedValue;
    }

    /**
     * Set the value of normalizedValue
     */
    protected function setNormalizedValue(mixed $normalizedValue = null): self {
        $this->normalizedValue = $normalizedValue;
        $this->mark();

        return $this;
    }

    /**
     * Get the value of maxValue
     */
    public function getMaxValue(): float {
        return $this->maxValue;
    }

    /**
     * Set the value of maxValue
     */
    public function setMaxValue(float $maxValue): self {
        $this->maxValue = $maxValue;
        $this->setNormalizedMaxValue($this->renormalizeValue($this->maxSiPrefix, $maxValue));

        return $this;
    }

    /**
     * Get the value of normalizedMaxValue
     */
    public function getNormalizedMaxValue(): mixed {
        return $this->normalizedMaxValue;
    }

    /**
     * Set the value of normalizedMaxValue
     */
    protected function setNormalizedMaxValue(mixed $normalizedMaxValue): self {
        $this->normalizedMaxValue = $normalizedMaxValue;
        $this->mark();

        return $this;
    }

    /**
     * Get the value of minValue
     */
    public function getMinValue(): float {
        return $this->minValue;
    }

    /**
     * Set the value of minValue
     */
    public function setMinValue(float $minValue): self {
        $this->minValue = $minValue;
        $this->setNormalizedMinValue($this->renormalizeValue($this->minSiPrefix, $minValue));

        return $this;
    }

    /**
     * Get the value of normalizedMinValue
     */
    public function getNormalizedMinValue(): mixed {
        return $this->normalizedMinValue;
    }

    /**
     * Set the value of normalizedMinValue
     */
    protected function setNormalizedMinValue(mixed $normalizedMinValue): self {
        $this->normalizedMinValue = $normalizedMinValue;
        $this->mark();

        return $this;
    }

    /**
     * Get the value of stringValue
     */
    public function getStringValue(): string {
        return $this->stringValue;
    }

    /**
     * Set the value of stringValue
     */
    public function setStringValue(string $stringValue): self {
        $this->stringValue = $stringValue;
        $this->mark();

        return $this;
    }

    /**
     * Get the value of valueType
     */
    public function getValueType(): string {
        if(!in_array($this->valueType, PartParameterValues::toArray())) {
            return PartParameterValues::NUM;
        }

        return $this->valueType;
    }

    /**
     * Set the value of valueType
     */
    public function setValueType($valueType): self {
        if(!in_array($valueType, PartParameterValues::toArray())) {
            throw new \Exception("Invalid value type given:".$valueType);
        }

        $this->valueType = $valueType;
        $this->mark();

        return $this;
    }

    /**
     * Get the value of siPrefix
     */
    public function getSiPrefix(): SiPrefix {
        return $this->siPrefix;
    }

    /**
     * Set the value of siPrefix
     */
    public function setSiPrefix(SiPrefix $siPrefix): self {
        $this->siPrefix = $siPrefix;
        $this->setNormalizedValue($this->renormalizeValue($siPrefix, $this->value));

        return $this;
    }

    /**
     * Get the value of minSiPrefix
     */
    public function getMinSiPrefix(): SiPrefix {
        return $this->minSiPrefix;
    }

    /**
     * Set the value of minSiPrefix
     */
    public function setMinSiPrefix(SiPrefix $minSiPrefix): self {
        $this->minSiPrefix = $minSiPrefix;
        $this->setNormalizedMinValue($this->renormalizeValue($minSiPrefix, $this->minValue));

        return $this;
    }

    /**
     * Get the value of maxSiPrefix
     */
    public function getMaxSiPrefix(): SiPrefix {
        return $this->maxSiPrefix;
    }

    /**
     * Set the value of maxSiPrefix
     */
    public function setMaxSiPrefix(SiPrefix $maxSiPrefix): self {
        $this->maxSiPrefix = $maxSiPrefix;
        $this->setNormalizedMaxValue($this->renormalizeValue($maxSiPrefix, $this->maxValue));

        return $this;
    }

    /** 
     *  #######################################
     *  Helper Functions to make life suck less
     *  #######################################
     */

    /** 
     *
     */
    public function setMin(SiPrefix $prefix, float $value): self {
        $this->minSiPrefix = $prefix;
        $this->minValue = $value;

        $this->setNormalizedMinValue($this->renormalizeValue($prefix, $value));

        return $this;
    }

    public function setNorm(SiPrefix $prefix, float $value): self {
        $this->siPrefix = $prefix;
        $this->value = $value;

        $this->setNormalizedValue($this->renormalizeValue($prefix, $value));

        return $this;
    }

    public function setMax(SiPrefix $prefix, float $value): self {
        $this->maxSiPrefix = $prefix;
        $this->maxValue = $value;

        $this->setNormalizedMaxValue($this->renormalizeValue($prefix, $value));

        return $this;
    }

    protected function renormalizeValue(SiPrefix $prefix, float $value): mixed {
        $norm = null;

        if($prefix === null) {
            $norm = $value;
        } else {
            $norm = $prefix->calculateProduct($value);
        }

        return $norm;
    }

    protected function renormalizeAllValues() {
        $this->setNormalizedMaxValue($this->renormalizeValue($this->maxSiPrefix, $this->maxValue))
        ->setNormalizedValue($this->renormalizeValue($this->siPrefix, $this->value))
        ->setNormalizedMinValue($this->renormalizeValue($this->minSiPrefix, $this->minValue));
    }
}