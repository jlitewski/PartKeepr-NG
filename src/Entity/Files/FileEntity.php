<?php
namespace App\Entity\Files;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Core\PKNGEntity;
use DateTime;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Represents a File stored on a storage device
 * 
 * @ORM\MappedSuperclass
 */
abstract class FileEntity extends PKNGEntity {

    /**
     * Specifies the type of the file.
     *
     * @ORM\Column(type="string")
     * @Groups({"default"})
     *
     * @Assert\NotNull
     * @var string
     **/
    private $type;

    /**
     * The unique filename of the file. Note that the filename does not contain any extension or any path information.
     *
     * @ORM\Column(type="string")
     * @Groups({"default"})
     *
     * @Assert\NotNull
     * @var string
     */
    private $filename;

    /**
     * The original name of the file. Includes the extension of the file, but no path information.
     *
     * @ORM\Column(type="string",nullable=true,name="originalname")
     * @Groups({"default"})
     *
     * @Assert\NotBlank(allowNull=true)
     * @var string
     */
    private $originalFilename;

    /**
     * The MimeType for the file.
     *
     * @ORM\Column(type="string")
     * @Groups({"default"})
     *
     * @Assert\NotNull
     * @var string
     */
    private $mimetype;

    /**
     * The size of the uploaded file.
     *
     * @ORM\Column(type="integer")
     * @Groups({"default"})
     *
     * @Assert\NotNull
     * @var int
     */
    private $size;

    /**
     * Holds the extension of the given file.
     *
     * @ORM\Column(type="string",nullable=true)
     * @Groups({"default"})
     *
     * @Assert\NotBlank(allowNull=true)
     * @var string
     */
    private $extension;

    /**
     * The description of this attachment.
     *
     * @ORM\Column(type="text",nullable=true)
     * @Groups({"default"})
     *
     * @Assert\NotBlank(allowNull=true)
     * @var string
     */
    private $description;

    /**
     * Holds an ID of a replacement image.
     *
     * @Groups({"default"})
     */
    private $replacement = null;

    /**
     * @ORM\Column(type="datetime")
     *
     * @Assert\DateTime
     * @var \DateTime
     */
    private $created;

    public function __construct() {
        $this->filename = Uuid::uuid1()->toString();
        $this->created = new \DateTime();
    }

    /**
     * 
     * @return DateTime 
     */
    public function getCreated(): \DateTime {
        return $this->created;
    }

    /**
     * Set the value of created
     */
    public function setCreated(\DateTime $created): self {
        $this->created = $created;
        $this->mark();

        return $this;
    }

    /**
     * Get the value of replacement
     */
    public function getReplacement() {
        return $this->replacement;
    }

    /**
     * Set the value of replacement
     * 
     * @todo figure out what type of parameter this is
     */
    public function setReplacement($replacement): self {
        $this->replacement = $replacement;
        $this->mark();

        return $this;
    }

    /**
     * Get the value of description
     */
    public function getDescription(): string {
        return $this->description;
    }

    /**
     * Set the value of description
     */
    public function setDescription(string $description): self {
        $this->description = $this->sanitizeInput($description, FILTER_SANITIZE_STRING);
        $this->mark();

        return $this;
    }

    /**
     * Get the value of extension
     */
    public function getExtension(): string {
        return $this->extension;
    }

    /**
     * Set the value of extension
     */
    public function setExtension(string $extension): self {
        $this->extension = $this->sanitizeInput($extension, FILTER_SANITIZE_STRING);
        $this->mark();

        return $this;
    }

    /**
     * Get the value of size
     */
    public function getSize(): int {
        return $this->size;
    }

    /**
     * Set the value of size
     */
    public function setSize(int $size): self {
        $this->size = $this->sanitizeInput($size, FILTER_SANITIZE_NUMBER_INT);
        $this->mark();

        return $this;
    }

    /**
     * Get the value of mimetype
     */
    public function getMimetype(): string {
        return $this->mimetype;
    }

    /**
     * Set the value of mimetype
     */
    public function setMimetype(string $mimetype): self {
        $this->mimetype = $this->sanitizeInput($mimetype, FILTER_SANITIZE_STRING);
        $this->mark();

        return $this;
    }

    /**
     * Get the value of originalFilename
     */
    public function getOriginalFilename(): string {
        return $this->originalFilename;
    }

    /**
     * Set the value of originalFilename
     */
    public function setOriginalFilename(string $originalFilename): self {
        $this->originalFilename = $this->sanitizeInput($originalFilename, FILTER_SANITIZE_STRING);
        $this->mark();

        return $this;
    }

    /**
     * Get the value of filename
     */
    public function getFilename(): string {
        return $this->filename;
    }

    /**
     * 
     * @return string 
     */
    public function getFullFilename(): string {
        return $this->filename.".".$this->extension;
    }

    /**
     * Set the value of filename
     */
    public function setFilename(string $filename): self {
        $this->filename = $this->sanitizeInput($filename, FILTER_SANITIZE_STRING);
        $this->mark();

        return $this;
    }

    /**
     * Get the value of type
     */
    public function getType(): string {
        return $this->type;
    }

    /**
     * Set the value of type
     */
    protected function setType(string $type): self {
        $this->type = $this->sanitizeInput($type, FILTER_SANITIZE_STRING);
        $this->mark();

        return $this;
    }
}