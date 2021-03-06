<?php
namespace App\Entity\Core;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Abstract class used as the basis of all PKNG Entities
 * 
 * @ORM\MappedSuperclass
 */
abstract class PKNGEntity {

    /**
     * Flag for when something changes inside the Entity, so we can run Validate()
     * 
     * @var bool
     */
    private bool $dirty = true;

    /**
     * Flag for when the Entity throws an recoverable error
     * 
     * @var bool
     */
    private bool $hasError = false;

    /**
     * The error message, if the Entity threw an error
     * 
     * @var string
     */
    private string $errorMsg; //TODO: Maybe make this an array for multiple messages?

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
     * @return int Entity ID
     */
    public function getID(): int {
        return $this->id;
    }

    public function __toString(): string {
        return get_class($this)." #".$this->getID();
    }

    /**
     * Returns 'true' if the Entity ran into an error
     * @return bool 
     */
    public final function hasError(): bool {
        return $this->hasError;
    }

    /**
     * Returns the Error Message if the Entity ran into an Error
     * @return string 
     */
    public final function getErrorMessage(): string {
        return $this->errorMsg;
    }

    /**
     * Sets the Error flag to true to signal we ran into an Error
     * @return PKNGEntity 
     */
    protected final function markError(): self {
        $this->hasError = true;

        return $this;
    }

    /**
     * Resets the Error flag and clears out any error messages
     */
    public final function clearError(): void {
        $this->hasError = false;
        $this->errorMsg = null;
    }

    /**
     * Sets the Error Message the Entity threw
     * 
     * @param string $message 
     * @return PKNGEntity 
     */
    protected final function setErrorMessage(string $message): self {
        $this->errorMsg = $message;

        return $this;
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
     * @internal THIS SHOULD ONLY BE USED INTERNALLY BY THE ENTITIES
     */
    protected final function mark(): void {
        if(!$this->isDirty()){
            $this->dirty = true;
        }
    }

    /**
     * Clears the dirty flag after running through a Validate() check
     */
    private final function clearMark(): void {
        if(!$this->isDirty()){
            $this->dirty = false;
        }
    }

    /**
     * Wrapper for filter_var to support nullable inputs
     * 
     * @return mixed|null Return the results of filter_var or null
     */
    protected final function sanitizeInput(?mixed $input, int $flag, bool $isNullable = false): ?mixed {
        if($isNullable && $input === null) return null;
        return filter_var($input, $flag);
    }

    /**
     * Validate the state of the Entity
     * This is to prevent the state of the Entity from going invalid and causing
     * headaches down the line
     * 
     * @return string|true Returns a string of errors, or true for a validated entity
     */
    public final function Validate(ValidatorInterface $validator): ?bool {
        if($this->isDirty()) { //We really shouldn't check validation if the entity isn't dirty
            $errors = $validator->validate($this);

            if(count($errors) > 0) { //There were errors with validation
                return (string)$errors;
            } else {
                $this->clearMark(); //Unmark the Entity as Dirty
                return true;
            }
        } else return true;
    }
}