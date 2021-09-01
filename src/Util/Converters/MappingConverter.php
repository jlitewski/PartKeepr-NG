<?php
namespace App\Util\Converters;

use Doctrine\ORM\Mapping\MappingException;
use Doctrine\ORM\Mapping\ClassMetadata;

final class MappingConverter {
    /**
     * Converts a PHP/Doctrine mapping to a ExtJS mapping
     * 
     * @param string $type The PHP/Doctrine type
     * @return string The ExtJS Type
     */
    public static function fromPHPtoExtJS(string $type): string {
        switch($type) {
            case 'integer':
                return 'int';
                break;
            case 'string':
                return 'string';
                break;
            case 'text':
                return 'string';
                break;
            case 'datetime':
                return 'date';
                break;
            case 'boolean':
                return 'boolean';
                break;
            case 'float':
                return 'number';
                break;
            case 'decimal':
                return 'number';
                break;
            case 'array':
                return 'array';
                break;
            default:
                return 'undefined';
                break;
        }
    }
}