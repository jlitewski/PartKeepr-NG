<?php
namespace App\Entity\Core;

use Doctrine\ORM\Mapping as ORM;

/**
 * Abstract class used as the basis of all PKNG Entities
 * 
 * @ORM\MappedSuperclass
 */
abstract class PKNGEntity {

    /**
     * Flag for when something changes inside the Entity, so we can run Valiadate()
     */
    private bool $dirty = true;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     * @var int $id The ID linked to this Entity
     */
    private $id;

    /**
     * Returns the ID linked to this Entity
     * 
     * @return int EntityID
     */
    public function getID(): int {
        return $this->id;
    }

    public function __toString(): string {
        return get_class($this)." #".$this->getID();
    }

    /**
     * Returns true if the PKNGEntity needs to run it's Validation() function
     * 
     * @return bool The status of the PKNGEntity
     */
    public final function isDirty(): bool {
        return $this->dirty;
    }

    /**
     * Represents a change to the PKNGEntity
     * 
     * THIS SHOULD ONLY BE USED INTERNALLY BY THE ENTITIES
     */
    protected final function mark() {
        if(!$this->isDirty()){
            $this->dirty = true;
        }
    }

    /**
     * Clears the dirty flag after running through a Validate() check
     * 
     * THIS SHOULD ONLY BE USED INTERNALLY BY THE ENTITIES
     */
    protected final function clearMark() {
        if(!$this->isDirty()){
            $this->dirty = false;
        }
    }

    /**
     * Validate the state of the Entity
     * This is to prevent the state of the Entity from going invalid and causing
     * headaches down the line
     * 
     * @throws InvalidEntityStateException
     */
    public abstract function Validate();
}