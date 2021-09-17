<?php
namespace App\Services\Core;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\NonUniqueResultException;
use App\Entity\Core\SystemPreference;
use App\Exception\Core\PreferenceNotFoundException;
use App\Util\Traits\TranslationTrait;
use Doctrine\ORM\ORMException;

;

class SystemPreferenceService {
    use TranslationTrait; //TODO: Implement the keys needed to fully use this

    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager) {
        $this->entityManager = $entityManager;
    }

    /**
     * Returns a SystemPreference based on the key given.
     * 
     * @param string $key The Preference Key
     * @return SystemPreference The Preference Entity for the key
     * @throws PreferenceNotFoundException 
     * @throws NoResultException
     * @throws NonUniqueResultException 
     */
    public function getPreference(string $key): SystemPreference {
        $query = $this->buildQuery($key);

        try {
            /** @var SystemPreference */
            $sp = $query->getSingleResult();

            return $sp;
        } catch (\Exception $e) {
            //TODO: Write out an actual error and run it through the translator
            throw new PreferenceNotFoundException($key, $e->getCode(), $e);
        }
    }

    /**
     * Returns every SystemPreference in the Database.
     * 
     * @return SystemPreference[] An array of SystemPreference objects
     * @throws ORMException 
     */
    public function getPreferences(): mixed {
        return $this->buildQuery()->getResult();
    }

    /**
     * Creates a new System Preference, or updates an existing Preference if the key
     * already exists
     * 
     * @param string $key the Preference Key
     * @param string $value The value to set for the key supplied
     * @return SystemPreference The SystemPreference Entity (either created or updated)
     */
    public function setPreference(string $key, string $value): SystemPreference {
        $query = $this->buildQuery($key);
        $preference = new SystemPreference();

        try {
            /** @var SystemPreference */
            $preference = $query->getSingleResult();
        } catch(\Exception $e) { //If the Key didn't exist in the DB, set up the Object we made above
            $preference->setKey($key);
            $this->entityManager->persist($preference);
        }

        $preference->setValue($value);
        $this->entityManager->flush();

        return $preference;
    }

    /**
     * Removes a SystemPreference. This won't do anything if the key doesn't exist
     * 
     * @param string $key The key to delete
     */
    public function deletePreference(string $key): void {
        if($key === null) return; //Idiot checking. Pretty sure this wouldn't work to begin with if passed through, but I don't trust people.

        $this->buildQuery($key, true)->execute();
    }

    /**
     * Helper function for building the DB Queries
     * 
     * @param string|null $key The key to use, or null
     * @param bool|false $delete Flag for using the DELETE verb; true for DELETE, false for SELECT
     * @return Query the DQL Query
     */
    private function buildQuery(?string $key = null, bool $delete = false): Query {
        /** @var string */
        $dql = '';
        /** @var Query */
        $query = null;

        //TODO: This could probably be done better, but it works for now
        if($key !== null) { //Key supplied
            if($delete) { //DELETE verb
                $dql = 'DELETE FROM App\Entity\Core\SystemPreference sp WHERE sp.preferenceKey = :key';
            } else {      //SELECT verb
                $dql = 'SELECT sp FROM App\Entity\Core\SystemPreference sp WHERE sp.preferenceKey = :key';
            }

            $query = $this->entityManager->createQuery($dql);
            $query->setParameter('key', $key);
        } else { //No key supplied
            $dql = "SELECT sp FROM App\Entity\Core\SystemPreference sp";
            $query = $this->entityManager->createQuery($dql);
        }

        return $query;
    }
}