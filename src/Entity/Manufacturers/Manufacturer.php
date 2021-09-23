<?php
namespace App\Entity\Manufacturers;

use App\Entity\Core\PKNGEntity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use App\Util\Annotation\TargetService;
use App\Util\Annotation\UploadedFileCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Represents a manufacturer.
 *
 * @ORM\Entity
 * @UniqueEntity("name")
 * @TargetService(uri="/api/manufacturers")
 **/
class Manufacturer extends PKNGEntity {
    /**
     * The name of the manufacturer.
     *
     * @ORM\Column(type="string",unique=true)
     * @Groups({"default"})
     *
     * @Assert\NotNull
     * @var string
     */
    private $name;

    /**
     * The address of the manufacturer.
     *
     * @ORM\Column(type="text",nullable=true)
     * @Groups({"default"})
     *
     * @Assert\NotBlank(allowBlank=true)
     * @var string
     */
    private $address;

    /**
     * The URL.
     *
     * @ORM\Column(type="string",nullable=true)
     * @Groups({"default"})
     *
     * @Assert\NotBlank(allowBlank=true)
     * @var string
     */
    private $url;

    /**
     * The email.
     *
     * @ORM\Column(type="string",nullable=true)
     * @Groups({"default"})
     *
     * @Assert\NotBlank(allowBlank=true)
     * @var string
     */
    private $email;

    /**
     * The comment.
     *
     * @ORM\Column(type="text",nullable=true)
     * @Groups({"default"})
     *
     * @Assert\NotBlank(allowBlank=true)
     * @var string
     */
    private $comment;

    /**
     * The phone number.
     *
     * @ORM\Column(type="string",nullable=true)
     * @Groups({"default"})
     *
     * @Assert\NotBlank(allowBlank=true)
     * @var string
     */
    private $phone;

    /**
     * The fax number.
     *
     * @ORM\Column(type="string",nullable=true)
     * @Groups({"default"})
     *
     * @Assert\NotBlank(allowBlank=true)
     * @var string
     */
    private $fax;

    /**
     * All logos of this manufacturer.
     * 
     * ### Note:
     * PartKeepr uses this as IC Logos, we are using this as Manufacturer Logos
     *
     * @ORM\OneToMany(
     *      targetEntity="App\Entity\Manufacturers\ManufacturerLogo",
     *      mappedBy="manufacturer",
     *      cascade={"persist", "remove"},
     *      orphanRemoval=true
     * )
     *
     * @UploadedFileCollection()
     * @Groups({"default"})
     * @ORM\Column(name="icLogos")
     */
    private $logos;

    /**
     * Creates a new manufacturer instance.
     */
    public function __construct() {
        $this->logos = new ArrayCollection();
    }

    /**
     * Get the value of name
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * Set the value of name
     */
    public function setName(string $name): self {
        $this->name = $this->sanitizeInput($name, FILTER_SANITIZE_STRING);
        $this->mark();

        return $this;
    }

    /**
     * Get the value of address
     */
    public function getAddress(): ?string {
        return $this->address;
    }

    /**
     * Set the value of address
     */
    public function setAddress(?string $address): self {
        $this->address = $this->sanitizeInput($address, FILTER_SANITIZE_STRING, true);
        $this->mark();

        return $this;
    }

    /**
     * Get the value of url
     */
    public function getUrl(): ?string {
        return $this->url;
    }

    /**
     * Set the value of url
     */
    public function setUrl(?string $url): self {
        if($url === null || preg_match('/^(http|https):\\/\\/[a-z0-9_]+([\\-\\.]{1}[a-z_0-9]+)*\\.[_a-z]{2,5}'.'((:[0-9]{1,5})?\\/.*)?$/i', $url)){
            $this->url = $url;
            $this->mark();
        } else {
            $this->markError()->setErrorMessage("Invalid URL format, should be similar to 'http://example.com/'");
        }

        return $this;
    }

    /**
     * Get the the email for the Manufacturer
     */
    public function getEmail(): ?string {
        return $this->email;
    }

    /**
     * Set the email for the Manufacturer
     */
    public function setEmail(?string $email): self {
        $temp = $this->sanitizeInput($email, FILTER_SANITIZE_EMAIL, true);
        if($temp !== null) {
            if(!filter_var($temp, FILTER_VALIDATE_EMAIL)) {
                $this->markError()->setErrorMessage("Invalid email format, should be similar to 'test@example.com'");
                return $this;
            }
        }

        $this->email = $temp;
        $this->mark();

        return $this;
    }

    /**
     * Gets the phone number for the Manufacturer
     */
    public function getPhone(): ?string {
        return $this->phone;
    }

    /**
     * Set the phone number of the Manufacturer
     */
    public function setPhone(?string $phone): self {
        $this->phone = $this->sanitizeInput($phone, FILTER_SANITIZE_NUMBER_INT, true);
        $this->mark();

        return $this;
    }

    /**
     * Get the fax number for the Manufacturer
     */
    public function getFax(): ?string {
        return $this->fax;
    }

    /**
     * Set the fax number for the Manufacturer
     */
    public function setFax(?string $fax): self {
        $this->fax = $this->sanitizeInput($fax, FILTER_SANITIZE_NUMBER_INT, true);
        $this->mark();

        return $this;
    }

    /**
     * Get the value of comment
     */
    public function getComment(): ?string {
        return $this->comment;
    }

    /**
     * Set the value of comment
     */
    public function setComment(?string $comment): self {
        $this->comment = $this->sanitizeInput($comment, FILTER_SANITIZE_STRING, true);
        $this->mark();

        return $this;
    }

    /**
     * Returns the Logos
     * 
     * @return ArrayCollection The array with all logos
     */
    public function getLogos() {
        return $this->logos->getValues();
    }

    /**
     * Adds a Logo.
     *
     * @param object $logo Either a ManufacturerICLogo or a TempImage
     * @todo implement the logic for this once ManufacturerLogo and TempImage are implemented
     */
    public function addLogo(object $logo) {
        /**
         * if ($logo instanceof ManufacturerLogo) {
         *     $logo->setManufacturer($this);
         * } else if($logo instanceof TempImage) {
         * 
         * }
         * 
         * $this->icLogos->add($logo);
         */
    }
}