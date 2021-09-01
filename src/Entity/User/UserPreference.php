<?php
namespace App\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use App\Util\Annotation\IgnoreIDs;
use App\Util\Annotation\TargetService;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Represents a user preference entry.
 *
 * User preferences are a simple key => value mechanism, where the developer can
 * specify the key and value himself.
 *
 * Note that values are stored internally as serialized PHP values to keep their type.
 *
 * @ORM\Entity
 * @TargetService(uri="/api/user_preferences")
 * @IgnoreIds()
 **/
class UserPreference {
    /**
     * Defines the key of the user preference.
     *
     * @ORM\Column(type="string",length=255)
     * @ORM\Id()
     *
     * @Groups({"default"})
     *
     * @var string
     */
    private $preferenceKey;

    /**
     * Defines the value. Note that the value is internally stored as a serialized string.
     *
     * @ORM\Column(type="text")
     *
     * @Groups({"default"})
     *
     * @var mixed
     */
    private $preferenceValue;

    /**
     * Defines the user.
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User\User")
     * @ORM\Id()
     *
     * @var User
     */
    private $user;

    /**
     * Get the value of preferenceKey
     */
    public function getPreferenceKey(): string {
        return $this->preferenceKey;
    }

    /**
     * Set the value of preferenceKey
     */
    public function setPreferenceKey(string $preferenceKey): self {
        $this->preferenceKey = $preferenceKey;

        return $this;
    }

    /**
     * Get the value of preferenceValue
     */
    public function getPreferenceValue(): mixed {
        return unserialize($this->preferenceValue);
    }

    /**
     * Set the value of preferenceValue
     */
    public function setPreferenceValue(string $preferenceValue): self {
        $this->preferenceValue = serialize($preferenceValue);

        return $this;
    }

    /**
     * Get the value of user
     * 
     * @return User The user that is associated with this preference
     */
    public function getUser(): User {
        return $this->user;
    }

    /**
     * Set the user for this preference
     */
    public function setUser(User $user): self {
        $this->user = $user;

        return $this;
    }
}