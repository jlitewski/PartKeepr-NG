<?php
namespace App\Util\Converters;

/**
 * Helper Methods to convert classnames from one thing to another
 * (for example, PHP class names to ExtJS)
 * 
 * @package App\Util\Converters
 */
final class ClassConverter {
    /**
     * Converts a PHP style class name to a ExtJS style class name
     * 
     * @param string $phpClassName The PHP class name
     * @return string The ExtJS class name
     */
    public static function fromPHPtoExtJS(string $phpClassName): string {
        return str_replace('\\', '.', $phpClassName);
    }

    /**
     * Converts a ExtJS style class name to a PHP style class anme
     * @param string $extjsClassName The ExtJS class name
     * @return string The PHP class name
     */
    public static function fromExtJStoPHP(string $extjsClassName): string {
        return str_replace('.', '\\', $extjsClassName);
    }
}