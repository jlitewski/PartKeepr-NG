<?php
namespace App\Entity\Batches;

use App\Entity\Batches\BatchJob;

//TODO: Write better APIDoc descriptions for these, these ones suck and don't really relay what they actually do

/**
 * An Interface that has common functions between multiple BatchJob Entities
 */
interface IBatchEntity {
    /**
     * Gets the description
     * 
     * @return string
     */
    public function getDescription(): string;

    /**
     * Sets the description
     * 
     * Please run Validate() before trying to do any database commands to prevent
     * any weirdness or invalid states from happening
     * 
     * @param string $description
     * @return self
     */
    public function setDescription(string $description): self;

    /**
     * Gets the BatchJob associated with this Entity
     * 
     * @return BatchJob
     */
    public function getBatchJob(): BatchJob;

    /**
     * Sets the BatchJob associated with this Entity. It can be null.
     * 
     * Please run Validate() before trying to do any database commands to prevent
     * any weirdness or invalid states from happening
     * 
     * @param BatchJob $job
     * @return self
     */
    public function setBatchJob(?BatchJob $job = null): self;

    /**
     * Gets the field name that needs work done to it
     * 
     * @return string
     */
    public function getProperty(): string;

    /**
     * Sets the field name that needs work done to it
     * 
     * Please run Validate() before trying to do any database commands to prevent
     * any weirdness or invalid states from happening
     * 
     * @param string $propertyName
     * @return self
     */
    public function setProperty(string $propertyName): self;

    /**
     * Gets the value of what we are working with
     * 
     * @return string
     */
    public function getValue(): string;

    /**
     * Sets the value of what we are working with
     * 
     * Please run Validate() before trying to do any database commands to prevent
     * any weirdness or invalid states from happening
     * 
     * @param string $value
     * @return self
     */
    public function setValue(string $value): self;

    /**
     * Returns if the value is dynamic or not
     * 
     * @return bool
     */
    public function isDynamic(): bool;

    /**
     * Sets if the value is dynamic or not
     * 
     * Please run Validate() before trying to do any database commands to prevent
     * any weirdness or invalid states from happening
     * 
     * @param bool $dynamic
     * @return self
     */
    public function setDynamic(bool $dynamic): self;
}