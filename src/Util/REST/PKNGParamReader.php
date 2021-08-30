<?php
namespace App\Util\REST;

use FOS\RestBundle\Request\ParamReaderInterface;
use FOS\RestBundle\Controller\Annotations\ParamInterface;
use Doctrine\Common\Annotations\Reader;

/**
 * Class loading "@ParamInterface" annotations from methods. Modified to read annotations from parent classes
 *
 * @author Alexander <iam.asm89@gmail.com>
 * @author Lukas Kahwe Smith <smith@pooteeweet.org>
 * @author Boris Guéry  <guery.b@gmail.com>
 * 
 * This Class is a replacement for FOS\RestBundle\Request\ParamReader, Modified for PartKeeper-NG
 */
final class PKNGParamReader implements ParamReaderInterface {
    private $annotationReader;

    public function __construct(Reader $annotationReader) {
        $this->annotationReader = $annotationReader;
    }

    /**
     * Modified to read annotations and parameters from a parent class
     * 
     * {@inheritdoc}
     */
    public function getParamsFromMethod(\ReflectionMethod $method): array {
        $parentParams = [];

        //This code does the exact same thing as ParamReader->getParamsFromMethod()
        $annotations = $this->annotationReader->getMethodAnnotations($method);
        $params = $this->getParamsFromAnnotationArray($annotations);

        // This loads the annotations of the parent method
        $parentClass = $method->getDeclaringClass()->getParentClass();

        if ($parentClass && $parentClass->hasMethod($method->getShortName())) {
            $parentMethod = $parentClass->getMethod($method->getShortName());
            $parentParams = $this->getParamsFromMethod($parentMethod);
        }

        return array_merge($params, $parentParams);
    }

     /**
     * {@inheritdoc}
     */
    public function read(\ReflectionClass $reflection, string $method): array {
        if (!$reflection->hasMethod($method)) {
            throw new \InvalidArgumentException(sprintf('Class "%s" has no method "%s".', $reflection->getName(), $method));
        }

        $methodParams = $this->getParamsFromMethod($reflection->getMethod($method));
        $classParams = $this->getParamsFromClass($reflection);

        return array_merge($methodParams, $classParams);
    }

    /**
     * {@inheritdoc}
     */
    public function getParamsFromClass(\ReflectionClass $class): array {
        $annotations = $this->annotationReader->getClassAnnotations($class);

        return $this->getParamsFromAnnotationArray($annotations);
    }

    /**
     * @return ParamInterface[]
     */
    private function getParamsFromAnnotationArray(array $annotations): array {
        $params = [];
        foreach ($annotations as $annotation) {
            if ($annotation instanceof ParamInterface) {
                $params[$annotation->getName()] = $annotation;
            }
        }

        return $params;
    }
}