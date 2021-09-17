<?php
namespace App\Util\Filters;

use App\Util\Enums\FilterOperators;
use App\Util\Enums\FilterTypes;
use App\Util\Traits\AssociationPropertyTrait;

class Filter implements IAssociationProperty {
    use AssociationPropertyTrait;

    /**
     * The type.
     *
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $operator;

    /**
     * @var string
     */
    private $value;

    /**
     * SubFilters.
     *
     * @var array
     */
    private $subFilters;

    public function __construct($type = FilterTypes::TYPE_AND) {
        $this->setType($type);
        $this->setSubFilters([]);
    }

    /**
     * @return string
     */
    public function getType(): string {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @throws \Exception
     */
    public function setType(string $type): self {
        if(!in_array($type, FilterTypes::toArray())) {
            throw new \Exception("Invalid type $type");
        }

        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getOperator(): string {
        return $this->operator;
    }

    /**
     * @param string $operator
     *
     * @throws \Exception Thrown if an invalid operator was passed
     */
    public function setOperator(string $operator): self {
        if (!in_array(strtolower($operator), FilterOperators::toArray())) {
            throw new \Exception("Invalid operator $operator");
        }

        $this->operator = strtolower($operator);
        return $this;
    }

    /**
     * @return string
     */
    public function getValue(): string {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue(string $value): self {
        $this->value = $value;

        return $this;
    }

    /**
     * @return array
     */
    public function getSubFilters(): array {
        return $this->subFilters;
    }

    /**
     * @param array $subFilters
     */
    public function setSubFilters($subFilters): self {
        $this->subFilters = $subFilters;

        return $this;
    }

    public function hasSubFilters(): bool {
        return count($this->subFilters) > 0;
    }
}