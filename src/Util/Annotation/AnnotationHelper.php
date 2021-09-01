<?php
namespace App\Util\Annotation;

use App\Util\Converters\MappingConverter;
use App\Util\Converters\ClassConverter;
use Doctrine\Common\Annotations\Reader;
use Doctrine\ORM\Mapping\ClassMetadata;

final class AnnotationHelper {
    /**
     * Gets all methods with the 'VirtualField' Annotation
     * 
     * @param Reader $reader The annotation reader to use
     * @param ClassMetadata $metadata The class metadata to check for the Annotation
     * @return array The array of methods with the annotation
     */
    public static function getVirtualFieldMappings(Reader $reader, ClassMetadata $metadata): array {
        $mappings = [];

        foreach($metadata->getReflectionClass()->getProperties() as $property) {
            /** @var VirtualField */
            $annotation = $reader->getPropertyAnnotation(
                $property,
                'App\Util\Annotation\VirtualField'
            );

            if($annotation !== null) {
                $mappings[] = [
                    'persist' => true,
                    'name'    => $property->getName(),
                    'type'    => MappingConverter::fromPHPtoExtJS($annotation->type)
                ];
            }
        }

        return $mappings;
    }

    /**
     * Gets all methods with the 'VirtualOneToMany' Annotation
     * 
     * @param Reader $reader The annotation reader to use
     * @param ClassMetadata $metadata The class metadata to check for the Annotation
     * @return array The array of methods with the annotation
     */
    public static function getVirtualOneToManyMappings(Reader $reader, ClassMetadata $metadata): array {
        $mappings = [];

        foreach($metadata->getReflectionClass()->getProperties() as $property) {
            /** @var VirtualOneToMany */
            $annotation = $reader->getPropertyAnnotation(
                $property,
                'App\Util\Annotation\VirtualOneToMany'
            );

            if($annotation !== null) {
                $mappings[] = [
                    'name'   => $property->getName(),
                    'target' => ClassConverter::fromPHPtoExtJS($annotation->target),
                ];
            }
        }

        return $mappings;
    }

    /**
     * Gets all methods with the 'ByReference' Annotation
     * 
     * @param Reader $reader The annotation reader to use
     * @param ClassMetadata $metadata The class metadata to check for the Annotation
     * @return array The array of methods with the annotation
     */
    public static function getByReferenceMappings(Reader $reader, ClassMetadata $metadata): array {
        $mappings = [];

        foreach ($metadata->getReflectionClass()->getProperties() as $property) {
            /** @var ByReference */
            $annotation = $reader->getPropertyAnnotation(
                $property,
                'App\Util\Annotation\ByReference'
            );

            if ($annotation !== null) {
                $mappings[] = $property->getName();
            }
        }

        return $mappings;
    }
}