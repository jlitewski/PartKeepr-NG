<?php
namespace App\Util\Enums;

final class FilterTypes extends BasicEnum {
    const TYPE_AND = 'and';
    const TYPE_OR = 'or';

    public static function toArray(): array {
        return [
            self::TYPE_AND,
            self::TYPE_OR
        ];
    }

}