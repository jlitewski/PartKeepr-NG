<?php
namespace App\Entity\Units;

use App\Entity\Core\PKNGEntity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use App\Util\Annotation\TargetService;
use App\Entity\Units\SiPrefix;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * This object represents an unit. Units can be: Volt, Hertz etc.
 *
 * @ORM\Entity
 * @TargetService(uri="/api/units")
 **/
class Unit extends PKNGEntity {
    /**
     * The name of the unit (e.g. Volts, Ampere, Farad, Metres).
     *
     * @ORM\Column(type="string")
     * @Groups({"default"})
     *
     * @var string
     */
    private $name;

    /**
     * The symbol of the unit (e.g. V, A, F, m).
     *
     * @ORM\Column(type="string")
     * @Groups({"default"})
     *
     * @var string
     */
    private $symbol;

    /**
     * Defines the allowed SiPrefixes for this parameter unit.
     *
     * @ORM\ManyToMany(targetEntity="PartKeepr\SiPrefixBundle\Entity\SiPrefix")
     * @ORM\JoinTable(name="UnitSiPrefixes",
     *            joinColumns={@ORM\JoinColumn(name="unit_id", referencedColumnName="id")},
     *            inverseJoinColumns={@ORM\JoinColumn(name="siprefix_id", referencedColumnName="id")}
     *            )
     * @Groups({"default"})
     * })
     *
     * @var ArrayCollection
     */
    private $prefixes;

    /**
     * Creates a new Unit.
     */
    public function __construct() {
        $this->prefixes = new ArrayCollection();
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
        $this->name = $this->sanitizeInput($name, FILTER_SANITIZE_STRING);
        $this->mark();

        return $this;
    }

    /**
     * Get the value of symbol
     */
    public function getSymbol(): string {
        return $this->symbol;
    }

    /**
     * Set the value of symbol
     */
    public function setSymbol(string $symbol): self {
        $this->symbol = $this->sanitizeInput($symbol, FILTER_SANITIZE_STRING);
        $this->mark();

        return $this;
    }

    /**
     * Get the value of prefixes
     */
    public function getPrefixes(): ArrayCollection {
        return $this->prefixes;
    }

    /**
     * Set the value of prefixes
     */
    public function addPrefix(SiPrefix $prefix): self {
        if(!$this->prefixes->contains($prefix)) {
            $this->prefixes->add($prefix);
            $this->mark();
        }

        return $this;
    }

    /**
     * Set the value of prefixes
     */
    public function removePrefix(SiPrefix $prefix): self {
        if($this->prefixes->contains($prefix)) {
            $this->prefixes->remove($prefix);
            $this->mark();
        }

        return $this;
    }

    public function Validate() {
        //TODO: Write out this logic, I just can't be asked to do it tonight because I'm tired
    }

}