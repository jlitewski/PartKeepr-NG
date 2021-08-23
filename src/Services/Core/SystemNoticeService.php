<?php
namespace App\Services\Core;

use Doctrine\ORM\EntityManager;

class SystemNoticeService {
    /**
     * 
     */
    public EntityManager $entityManager;

    public function __construct(EntityManager $entityManager) {
        $this->entityManager = $entityManager;
    }

    //TODO: Fill out this stub after figuring out what the original code did
    public function createUniqueSystemNotice() {

    }
}