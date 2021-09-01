<?php
namespace App\Services\Annotations;

use App\Util\Converters\ClassConverter;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\Common\Annotations\Reader;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\NotBlank;

class ReflectionService {
    protected $manager;

    protected $templateEngine;

    protected $reader;

    public function __construct(Registry $doctrine, EngineInterface $templateEngine, Reader $reader) {
        $this->manager = $doctrine->getManager();
        $this->templateEngine = $templateEngine;
        $this->reader = $reader;
    }

    public function getEntities(): array {
        $entities = [];
        $meta = $this->manager->getMetadataFactory()->getAllMetadata();

        foreach($meta as $m) {
            $entities[] = ClassConverter::fromPHPtoExtJS($m->getName());
        }

        return $entities;
    }

    
}