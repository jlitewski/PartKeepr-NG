<?php
namespace App\Entity\Category;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Entity\Core\PKNGEntity;

/**
 * @ORM\MappedSuperclass()
 * @ORM\Table(indexes={@ORM\Index(columns={"lft"}),@ORM\Index(columns={"rgt"})})
 *
 * Represents an abstract category. This class isn't directly usable; you need to inherit it to take advantage of
 * the AbstractCategoryManager.
 *
 * If you are interested on how NestedSets work, please read http://en.wikipedia.org/wiki/Nested_set_model
 */
abstract class AbstractCategory extends PKNGEntity {
    /**
     * The parent category. This needs to be re-defined in the class with the proper relations.
     *
     * @var
     */
    protected $parent;

    /**
     * The "left" property of the nested set.
     *
     * @ORM\Column(type="integer")
     *
     * @Gedmo\TreeLeft
     *
     * @var int
     */
    private $lft;

    /**
     * The "right" property of the nested set.
     *
     * @ORM\Column(type="integer")
     *
     * @Gedmo\TreeRight
     *
     * @var int
     */
    private $rgt;

    /**
     * @Gedmo\TreeLevel
     * @ORM\Column(name="lvl", type="integer")
     *
     * @var int
     */
    private $lvl;

    /**
     * @Gedmo\TreeRoot
     * @ORM\Column(name="root", type="integer", nullable=true)
     */
    private $root;

    /**
     * The name of the category.
     *
     * @ORM\Column(length=128)
     * @Groups({"default"})
     *
     * @var string
     */
    private $name;

    /**
     * The description of the category.
     *
     * @ORM\Column(type="text",nullable=true)
     * @Groups({"default"})
     *
     * @var string
     */
    private $description;

    /**
     * @Groups({"default"})
     *
     * @var bool
     */
    public $expanded = true;

    public function __construct() {
        $this->children = new ArrayCollection();
    }

    /**
     * Returns the description of this category.
     *
     * @return string The description
     */
    public function getDescription(): string {
        return $this->description;
    }

    /**
     * Sets the description for this category.
     *
     * @param string $description The description of this category
     */
    public function setDescription(string $description): self {
        $this->description = $description;
        $this->mark();

        return $this;
    }

    /**
     * Returns the name of this category.
     *
     * @return string The category name
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * Sets the name of this category.
     *
     * @param string $name The name to set
     */
    public function setName(string $name): self {
        $this->name = $name;
        $this->mark();

        return $this;
    }

    /**
     * Returns the level of this category.
     *
     * @return int
     */
    public function getLevel(): int {
        return $this->lvl;
    }
}