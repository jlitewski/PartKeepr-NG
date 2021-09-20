<?php
namespace App\Entity\Batches;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Core\PKNGEntity;
use App\Util\Annotation\TargetService;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Exception\Core\InvalidEntityStateException;
use Doctrine\Common\Collections\ArrayCollection;

//TODO: Flesh out the PHPDocs for the methods

/**
 * @ORM\Entity
 * @TargetService(uri="/api/batch_jobs")
 */
class BatchJob extends PKNGEntity {

    /**
     * The name of the BatchJob
     * 
     * @ORM\Column(length=64,unique=true)
     * @Groups({"default"})
     *
     * @var string
     */
    private $name;

    /**
     * The fields to query, in an array
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Batches\BatchQueryField",mappedBy="batchJob",cascade={"persist", "remove"}, orphanRemoval=true)
     * @Groups({"default"})
     *
     * @var ArrayCollection
     */
    private $batchJobQueryFields;

    /**
     * The fields to update, in an array
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Batches\BatchUpdateField",mappedBy="batchJob",cascade={"persist", "remove"}, orphanRemoval=true)
     * @Groups({"default"})
     *
     * @var ArrayCollection
     */
    private $batchJobUpdateFields;

    /**
     * Holds the base entity to query against.
     *
     * @ORM\Column()
     * @Groups({"default"})
     *
     * @var string
     */
    private $baseEntity;

    public function __construct() {
        $this->batchJobQueryFields = new ArrayCollection();
        $this->batchJobUpdateFields = new ArrayCollection();
    }

    /**
     * Gets the BatchJob's array of fields to Update
     * 
     * @return ArrayCollection
     */
    public function getBatchJobUpdateFields() {
        return $this->batchJobUpdateFields->getValues();
    }

    /**
     * Returns the name of the PKNGEntity this BatchJob is associated with
     * 
     * @return string
     */
    public function getPKNGEntityName(): string {
        return $this->baseEntity;
    }

    /**
     * Sets the name of the PKNGEntity this BatchJob is associated with, and marks
     * the Entity as dirty.
     * 
     * Please run Validate() before trying to do any database commands to prevent
     * any weirdness or invalid states from happening
     * 
     * @param string $entityName
     * @return self
     */
    public function setPKNGEntityName(string $entityName): self {
        $this->baseEntity = $entityName;
        $this->mark();

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getBatchQueryFields() {
        return $this->batchJobQueryFields->getValues();
    }

    /**
     * @param BatchQueryField $batchJobQueryField 
     * @return self
     */
    public function addBatchJobQueryField(BatchQueryField $batchJobQueryField): self {
        if ($batchJobQueryField instanceof BatchQueryField) {
            $batchJobQueryField->setBatchJob($this);
        }

        $this->batchJobQueryFields->add($batchJobQueryField);
        $this->mark();

        return $this;
    }

    /**
     * @param BatchQueryField $batchJobQueryField 
     * @return self
     */
    public function removeBatchJobQueryField(BatchQueryField $batchJobQueryField): self {
        if ($batchJobQueryField instanceof BatchQueryField) {
            $batchJobQueryField->setBatchJob(null);
        }
        $this->batchJobQueryFields->removeElement($batchJobQueryField);
        $this->mark();
        
        return $this;
    }

    /**
     * @param BatchUpdateField $batchJobUpdateField 
     * @return self
     */
    public function addBatchJobUpdateField(BatchUpdateField $batchJobUpdateField): self {
        if ($batchJobUpdateField instanceof BatchUpdateField) {
            $batchJobUpdateField->setBatchJob($this);
        }
        $this->batchJobUpdateFields->add($batchJobUpdateField);
        $this->mark();
        
        return $this;
    }

    /**
     * @param BatchUpdateField $batchJobUpdateField 
     * @return void 
     */
    public function removeBatchJobUpdateField(BatchUpdateField $batchJobUpdateField): self {
        if ($batchJobUpdateField instanceof BatchUpdateField) {
            $batchJobUpdateField->setBatchJob(null);
        }
        $this->batchJobUpdateFields->removeElement($batchJobUpdateField);
        $this->mark();
        
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * @param string $name
     * @return self
     */
    public function setName(string $name): self {
        $this->name = $this->sanitizeInput($name, FILTER_SANITIZE_STRING);
        $this->mark();

        return $this;
    }

    public function Validate() {
        if($this->isDirty()) {
            if(!is_string($this->name)) {
                throw new InvalidEntityStateException("Name has to be a string! Entity '".$this->__toString()."'");
            }

            if(!is_string($this->baseEntity)) {
                throw new InvalidEntityStateException("BaseEntity has to be a string! Entity '".$this->__toString()."'");
            }

            if(!($this->batchJobQueryFields instanceof ArrayCollection)) {
                throw new InvalidEntityStateException("\$batchJobQueryFields not instance of ArrayCollection! Entity '".$this->__toString()."'");
            }

            if(!($this->batchJobUpdateFields instanceof ArrayCollection)) {
                throw new InvalidEntityStateException("\$batchJobUpdateFields not instance of ArrayCollection! Entity '".$this->__toString()."'");
            }

            $this->clearMark();
        }
    }
}