<?php
namespace App\Entity\Distributors;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Core\PKNGEntity;
use App\Util\Annotation\TargetService;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Represents a distributor.
 *
 * @ORM\Entity
 * @TargetService(uri="/api/distributors")
 **/
class Distributor extends PKNGEntity {
    /**
     * Holds the name of the distributor.
     *
     * @ORM\Column(type="string",unique=true)
     * @Groups({"default"})
     *
     * @var string
     */
    private $name;

    /**
     * Holds the address of the distributor.
     *
     * @ORM\Column(type="text",nullable=true)
     * @Groups({"default"})
     *
     * @var string
     */
    private $address;

    /**
     * Holds the URL of the distributor.
     *
     * @ORM\Column(type="string",nullable=true)
     * @Groups({"default"})
     *
     * @var string
     */
    private $url;

    /**
     * Holds the phone number of the distributor.
     *
     * @ORM\Column(type="string",nullable=true)
     * @Groups({"default"})
     *
     * @var string
     */
    private $phone;

    /**
     * Holds the fax number of the distributor.
     *
     * @ORM\Column(type="string",nullable=true)
     * @Groups({"default"})
     *
     * @var string
     */
    private $fax;

    /**
     * Holds the email of the distributor.
     *
     * @ORM\Column(type="string",nullable=true)
     * @Groups({"default"})
     *
     * @var string
     */
    private $email;

    /**
     * Holds a comment for the distributor.
     *
     * @ORM\Column(type="text",nullable=true)
     * @Groups({"default"})
     *
     * @var string
     */
    private $comment;

    /**
     * Holds the SKU lookup URL of the distributor.
     *
     * @ORM\Column(type="string", name="skuurl", nullable=true)
     * @Groups({"default"})
     *
     * @var string
     */
    private $lookupURL;

    /**
     * Defines if the distributor is used for pricing calculations.
     *
     * @ORM\Column(type="boolean",options={"default":false})
     * @Groups({"default"})
     *
     * @var bool
     */
    private $enabledForReports = true;

    /**
     * Gets the name of this distributor
     * @return string The name of this distributor
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * Set the name of this distributor
     * @param string $name The name of this distributor
     * @return self
     */
    public function setName(string $name): self {
        $this->name = $name;
        $this->mark();

        return $this;
    }

    /**
     * Gets the address of this distributor. Can be null
     * @return string|null The address of this distributor
     */
    public function getAddress(): ?string {
        return $this->address;
    }

    /**
     * Set the value of address
     */
    public function setAddress(string $address = null): self {
        $this->address = $address;
        $this->mark();

        return $this;
    }

    /**
     * Get the value of url
     */
    public function getUrl(): string {
        return $this->url;
    }

    /**
     * Set the value of url
     */
    public function setUrl(string $url = null): self {
        $this->url = $url;

        return $this;
    }

    /**
     * Get the value of phone
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set the value of phone
     */
    public function setPhone($phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get the value of fax
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set the value of fax
     */
    public function setFax($fax): self
    {
        $this->fax = $fax;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     */
    public function setEmail($email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of comment
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set the value of comment
     */
    public function setComment($comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get the value of lookupURL
     */
    public function getLookupURL()
    {
        return $this->lookupURL;
    }

    /**
     * Set the value of lookupURL
     */
    public function setLookupURL($lookupURL): self
    {
        $this->lookupURL = $lookupURL;

        return $this;
    }

    /**
     * Get the value of enabledForReports
     */
    public function getEnabledForReports()
    {
        return $this->enabledForReports;
    }

    /**
     * Set the value of enabledForReports
     */
    public function setEnabledForReports($enabledForReports): self
    {
        $this->enabledForReports = $enabledForReports;

        return $this;
    }

    public function Validate() { }
}