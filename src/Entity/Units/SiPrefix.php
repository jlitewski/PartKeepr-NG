<?php
namespace App\Entity\Units;

use App\Entity\Core\PKNGEntity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use PartKeepr\DoctrineReflectionBundle\Annotation\TargetService;

/**
 * Represents an SI Prefix.
 *
 * @link http://en.wikipedia.org/wiki/Metric_prefix
 *
 * @ORM\Entity
 * @TargetService(uri="/api/si_prefixes")
 */
class SiPrefix extends PKNGEntity {
    /**
     * The name of the Si-Prefix (i.e. deca, deci, centi, etc.)
     * 
     * @ORM\Column(type="string")
     * @Groups({"default"})
     * 
     * @var string
     */
    private $prefix;

    /**
     * The symbol of the Si-Prefix (e.g. m, M, G).
     *
     * @ORM\Column(type="string",length=2)
     * @Groups({"default"})
     *
     * @var string
     */
    private $symbol;

    /**
     * The exponent of the Si-Prefix (e.g. milli = 10^-3).
     *
     * @ORM\Column(type="integer")
     * @Groups({"default"})
     *
     * @var int
     */
    private $exponent;

    /**
     * The base of the Si-Prefix (e.g. 2^-3).
     *
     * @ORM\Column(type="integer")
     * @Groups({"default"})
     *
     * @var int
     */
    private $base;

    /**
     * Get the value of prefix
     * 
     * @return string
     */
    public function getPrefix(): string {
        return $this->prefix;
    }

    /**
     * Set the value of prefix
     * 
     * @param string $prefix
     * @return self
     */
    public function setPrefix(string $prefix): self {
        $this->prefix = $prefix;
        $this->mark();

        return $this;
    }

    /**
     * Get the value of symbol
     * 
     * @return string
     */
    public function getSymbol(): string {
        return $this->symbol;
    }

    /**
     * Set the value of symbol
     * 
     * @param string $symbol
     * @return self
     */
    public function setSymbol(string $symbol): self {
        $this->symbol = $symbol;
        $this->mark();

        return $this;
    }

    /**
     * Get the value of exponent
     * 
     * @return int
     */
    public function getExponent(): int {
        return $this->exponent;
    }

    /**
     * Sets the value of exponent
     * 
     * @param int $exponent
     * @return self
     */
    public function setExponent(int $exponent): self {
        $this->exponent = $exponent;
        $this->mark();

        return $this;
    }

    /**
     * Gets the value of base
     * 
     * @return int
     */
    public function getBase(): int {
        return $this->base;
    }

    /**
     * Sets the value of base
     * 
     * @param int $base
     * @return self 
     */
    public function setBase(int $base): self {
        $this->base = $base;
        $this->mark();

        return $this;
    }

    /**
     * Utility function that calculates the product for a given value.
     *
     * @param float $value The value to calculate the product
     *
     * @return float The resulting value
     */
    public function calculateProduct(float $value): float {
        return $value * pow($this->base, $this->exponent);
    }

    public function Validate() {
        //TODO: Write out this logic, I just can't be asked to do it tonight because I'm tired
    }
}