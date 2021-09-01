<?php
namespace App\Util\Enums;

final class FilterOperators extends BasicEnum {
    const OP_LESS_THAN = '<';
    const OP_GREATER_THAN = '>';
    const OP_EQUALS = '=';
    const OP_GREATER_THAN_EQUALS = '>=';
    const OP_LESS_THAN_EQUALS = '<=';
    const OP_NOT_EQUALS = '!=';
    const OP_IN = 'in';
    const OP_LIKE = 'like';

    public static function toArray(): array {
        return [
            self::OP_LESS_THAN,
            self::OP_GREATER_THAN,
            self::OP_EQUALS,
            self::OP_GREATER_THAN_EQUALS,
            self::OP_LESS_THAN_EQUALS,
            self::OP_NOT_EQUALS,
            self::OP_IN,
            self::OP_LIKE
        ];
    }

}