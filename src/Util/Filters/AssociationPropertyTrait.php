<?php
namespace App\Util\Filters;

trait AssociationPropertyTrait {
    /**
     * @var string
     */
    private $property;
    /**
     * @var string
     */
    private $association;

    /**
     * @return string
     */
    public function getProperty(): string {
        return $this->property;
    }

    /**
     * @param string $property
     */
    public function setProperty(string $property): self {
        $this->property = $property;

        return $this;
    }

    /**
     * @return string
     */
    public function getAssociation(): string {
        return $this->association;
    }

    /**
     * @param string $association
     */
    public function setAssociation(string $association): self {
        $this->association = $association;
        return $this;
    }
}