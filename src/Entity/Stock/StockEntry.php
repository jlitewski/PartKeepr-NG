<?php
namespace App\Entity\Stock;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\User\User;
use App\Entity\Core\PKNGEntity;
use App\Util\Annotation\TargetService;
use App\Entity\Parts\Part;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @TargetService(uri="/api/stock_entries")
 */
class StockEntry extends PKNGEntity {
    /**
     * @ORM\Column(type="integer", name="stockLevel")
     * @Groups({"default"})
     * 
     * @var int
     */
    private $stockChange;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Parts\Part", inversedBy="stockLevels")
     * @Groups({"default"})
     * 
     * @var Part
     */
    private $part;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User\User")
     * @Groups({"default"})
     * 
     * @var User
     */
    private $user;

    /**
     * The price per item.
     *
     * @ORM\Column(type="decimal",precision=13,scale=4,nullable=true)
     * @Groups({"default"})
     *
     * @var float
     */
    private $price;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"default"})
     *
     * @var \DateTime
     */
    private $dateTime;

    /**
     * Indicates if the stock level is a correction entry.
     *
     * @ORM\Column(type="boolean")
     * @Groups({"default"})
     *
     * @var bool
     */
    private $correction;

    /**
     * @ORM\Column(type="string",nullable=true)
     * @Groups({"default"})
     *
     * @var string
     */
    private $comment;

    /**
     * Creates a new stock entry. A stock entry tracks how many parts
     * were the stockLevel is the amount of items added/removed,
     * by which user and how much the user paid for it (for adding parts only!).
     */
    public function __construct() {
        $this->dateTime = new \DateTime();
        $this->correction = false;
    }

    /**
     * Returns the date+time when the record was created.
     *
     * @return \DateTime The date+time when the record was created
     */
    public function getDateTime(): \DateTime {
        return $this->dateTime;
    }

    /**
     * Sets if the stock entry is a correction record.
     * 
     * @param bool $flag True if this record is a correction record, false otherwise
     * @return StockEntry 
     */
    public function correctionRecord(bool $flag): self {
        $this->correction = $flag;
        $this->mark();

        return $this;
    }

    /**
     * Returns if the stock entry is a correction record
     * 
     * @return bool True for a correction, false otherwise
     */
    public function isCorrection(): bool {
        return $this->correction;
    }

    /**
     * Returns if this Stock Entry has a price associated with it.
     * 
     * @return bool True if it does, false otherwise
     */
    public function hasPrice(): bool {
        return $this->price !== null;
    }

    /**
     * Get the price for this entry.
     * 
     * The price is for a single item only, and can be null
     */
    public function getPrice(): ?float {
        return $this->price;
    }

    /**
     * Sets the price for the item stored.
     *
     * Please note that the price is for a single item only, and can be null.
     
     * @param $price The price to set (as a float), or null to remove the price
     * @return StockEntry
     */
    public function setPrice(?float $price): self {
        $this->price = $this->sanitizeInput($price, FILTER_SANITIZE_NUMBER_FLOAT, true);
        $this->fixNegativePricing();
        $this->mark();

        return $this;
    }

    /**
     * Helper function to prevent a removal stock entry from having a price. This is called during
     * Doctrine's PrePersist event trigger, and is also called internally when messing with the
     * stock levels and pricing to prevent it from happening.
     * 
     * @ORM\PrePersist
     * @return void
     * @internal Please don't use this function in production code
     */
    public final function fixNegativePricing(): void {
        if($this->isRemoval() && $this->hasPrice()) {
            $this->price = null;
        }
    }

    /**
     * Returns the change in stock for this stock entry.
     *
     * @return int The stock level
     */
    public function getStockChange(): int {
        return $this->stockChange;
    }

    /**
     * Sets the change in stock for this entry.
     *
     * Negative values means removing stock, positive values means adding stock.
     *
     * @param int $change The change in stock
     * @return StockEntry
     */
    public function setStockChangedAmount(int $change): self {
        $this->stockChange = $this->sanitizeInput($change, FILTER_SANITIZE_NUMBER_INT);
        $this->fixNegativePricing();
        $this->mark();

        return $this;
    }

    /**
     * Returns if this stock entry is a removal
     *
     * @return boolean True if it is, false otherwise
     */
    public function isRemoval(): bool {
        return $this->stockChange < 0;
    }

    /**
     * Get the comment for this stock entry
     * 
     * @return string The comment for this StockEntry
     */
    public function getComment(): string {
        if($this->comment === null) return "";
        else return $this->comment;
    }

    /**
     * Sets a comment on this stock entry
     * 
     * @param string $comment The comment for this StockEntry
     * @return StockEntry
     */
    public function setComment(?string $comment): self {
        $this->comment = $this->sanitizeInput($comment, FILTER_SANITIZE_STRING);
        $this->mark();

        return $this;
    }

    //TODO: Figure out if this is suppose to be nullable or not
    /**
     * Returns the user linked to this StockEntry.
     * 
     * According to the OG PartKeepr codebase, this could be null. I'm not sure if that's intended or not,
     * so I'm leaving it in until I know for sure. 
     *
     * @return User|null The user linked to this StockEntry, or null if there is none
     */
    public function getUser(): ?User {
        return $this->user;
    }

    //TODO: Figure out if this is suppose to be nullable or not
    /**
     * Sets the user assigned to this entry.
     * 
     * According to the OG PartKeepr codebase, this could be null. I'm not sure if that's intended or not,
     * so I'm leaving it in until I know for sure. 
     *
     * @param User $user The user The user to set
     * @return StockEntry
     */
    public function setUser(?User $user = null): self {
        $this->user = $user;
        $this->mark();

        return $this;
    }

    //TODO: Figure out if this is suppose to be nullable or not
    /**
     * Returns the part assigned to this entry.
     * 
     * According to the OG PartKeepr codebase, this could be null. I'm not sure if that's intended or not,
     * so I'm leaving it in until I know for sure. 
     *
     * @return Part|null The part linked to this StockEntry, or null if there is none
     */
    public function getPart(): ?Part {
        return $this->part;
    }

    //TODO: Figure out if this is suppose to be nullable or not
    /**
     * Sets the part assigned to this entry.
     * 
     * According to the OG PartKeepr codebase, this could be null. I'm not sure if that's intended or not,
     * so I'm leaving it in until I know for sure. 
     *
     * @param Part $part The part to set
     * @return StockEntry
     */
    public function setPart(?Part $part = null): self {
        $this->part = $part;
        $this->mark();

        return $this;
    }

    public function Validate() { }
}
