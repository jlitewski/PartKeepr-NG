<?php
namespace App\Entity\Batches;

use App\Entity\Core\PKNGEntity;
use App\Exception\Core\InvalidEntityStateException;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

//TODO: Flesh out the PHPDocs for the operator method

/**
 * Represents a batch job query field.
 *
 * @ORM\Entity
 */
class BatchQueryField extends PKNGEntity implements IBatchEntity {

    /**
     * The part this batch job query field refers to.
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Batches\BatchJob", inversedBy="batchJobQueryFields")
     *
     * @var BatchJob
     */
    private $batchJob = null;

    /**
     * The field name to query.
     *
     * @ORM\Column(length=255)
     * @Groups({"default"})
     *
     * @var string
     */
    private $property;

    /**
     * The operator to use.
     *
     * @ORM\Column(length=64)
     * @Groups({"default"})
     *
     * @var string
     */
    private $operator;

    /**
     * The value. May be an array if the operator is IN.
     *
     * @ORM\Column(type="text")
     * @Groups({"default"})
     *
     * @var string
     */
    private $value;

    /**
     * The description.
     *
     * @ORM\Column(type="text")
     * @Groups({"default"})
     *
     * @var string
     */
    private $description;

    /**
     * Defines if the value is dynamic (=the user gets prompted upon running the batch job which value to use).
     *
     * @Groups({"default"})
     * @ORM\Column(type="boolean")
     *
     * @var bool
     */
    private $dynamic;

    public function getDescription(): string {
        return $this->description;
    }

    public function setDescription(string $description): self {
        $this->description = $description;
        $this->mark();

        return $this;
    }

    public function getBatchJob(): BatchJob {
        return $this->batchJob;
    }

    public function setBatchJob(?BatchJob $job = null): self {
        $this->batchJob = $job;
        $this->mark();

        return $this;
    }

    public function getProperty(): string {
        return $this->property;
    }

    public function setProperty(string $propertyName): self {
        $this->property = $propertyName;
        $this->mark();

        return $this;
    }

    public function getValue(): string {
        return $this->value;
    }

    public function setValue(string $value): self {
        $this->value = $value;
        $this->mark();

        return $this;
    }

    public function isDynamic(): bool {
        return $this->dynamic;
    }

    public function setDynamic(bool $dynamic): self {
        $this->dynamic = $dynamic;
        $this->mark();

        return $this;
    }

    /**
     * Get the value of operator
     */
    public function getOperator()
    {
        return $this->operator;
    }

    /**
     * Set the value of operator
     */
    public function setOperator(string $operator): self
    {
        $this->operator = $operator;

        return $this;
    }
}