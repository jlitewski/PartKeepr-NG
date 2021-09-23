<?php
namespace App\Entity\Category;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Entity\Core\PKNGEntity;

/**
 * Represents an abstract category. This class isn't directly usable; you need to inherit it to take advantage of
 * the AbstractCategoryManager.
 *
 * If you are interested on how NestedSets work, please read http://en.wikipedia.org/wiki/Nested_set_model
 * 
 * @ORM\MappedSuperclass()
 * @ORM\Table(
 *      indexes={
 *          @ORM\Index(columns={"lft"}),
 *          @ORM\Index(columns={"rgt"})
 *      }
 * )
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
     * @Gedmo\TreeLeft
     * @ORM\Column(name="lft", type="integer")
     * 
     * @Assert\NotNull
     * @var int
     */
    private $left;

    /**
     * The "right" property of the nested set.
     *
     * @Gedmo\TreeRight
     * @ORM\Column(name="rgt", type="integer")
     *
     * @Assert\NotNull
     * @var int
     */
    private $right;

    /**
     * @Gedmo\TreeLevel
     * @ORM\Column(name="lvl", type="integer")
     *
     * @Assert\NotNull
     * @var int
     */
    private $level;

    /**
     * @Gedmo\TreeRoot
     * @ORM\Column(name="root", type="integer", nullable=true)
     * 
     * @Assert\NotBlank(allowNull=true)
     * @var int
     */
    private $root;

    /**
     * The name of the category.
     *
     * @ORM\Column(length=128)
     * @Groups({"default"})
     * 
     * @Assert\NotNull
     * @Assert\Length(max=128)
     * @var string
     */
    private $name;

    /**
     * The description of the category.
     *
     * @ORM\Column(type="text",nullable=true)
     * @Groups({"default"})
     *
     * @Assert\NotBlank(allowNull=true)
     * @var string
     */
    private $description;

    /**
     * @Groups({"default"})
     *
     * @Assert\NotNull
     * @var bool
     */
    private $expanded = true;

    public function __construct() {
        $this->children = new ArrayCollection();
    }

    /**
     * Returns the description of this category.
     *
     * @return string|null The description
     */
    public function getDescription(): ?string {
        return $this->description;
    }

    /**
     * Sets the description for this category.
     *
     * @param string|null $description The description of this category
     */
    public function setDescription(?string $description): self {
        $this->description = $this->sanitizeInput($description, FILTER_SANITIZE_STRING, true);
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
        $this->name = $this->sanitizeInput($name, FILTER_SANITIZE_STRING);
        $this->mark();

        return $this;
    }

    /**
     * Returns the level of this category.
     *
     * @return int
     */
    public function getLevel(): int {
        return $this->level;
    }

    /**
     * 
     * @return int 
     */
    public function left(): int {
        return $this->left;
    }

    /**
     * 
     * @param int $categoryID 
     * @return AbstractCategory 
     */
    public function setLeft(int $categoryID): self {
        $this->left = $this->sanitizeInput($categoryID, FILTER_SANITIZE_NUMBER_INT);
        $this->mark();

        return $this;
    }

    /**
     * 
     * @return int 
     */
    public function right(): int {
        return $this->right;
    }

    /**
     * 
     * @param int $categoryID 
     * @return AbstractCategory 
     */
    public function setRight(int $categoryID): self {
        $this->right = $this->sanitizeInput($categoryID, FILTER_SANITIZE_NUMBER_INT);
        $this->mark();

        return $this;
    }

    /**
     * 
     * @return int|null
     */
    public function root(): ?int {
        return $this->root;
    }

    /**
     * 
     * @param int|null $categoryID 
     * @return AbstractCategory 
     */
    public function setRoot(?int $categoryID): self {
        $this->root = $this->sanitizeInput($categoryID, FILTER_SANITIZE_NUMBER_INT, true);
        $this->mark();

        return $this;
    }

    /**
     * Get the value of expanded
     */
    public function isExpanded() {
        return $this->expanded;
    }

    /**
     * Set the value of expanded
     */
    public function expand(bool $flag): self {
        $this->expanded = $flag;
        $this->mark();

        return $this;
    }
}