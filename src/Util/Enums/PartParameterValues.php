<?php
namespace App\Util\Enums;

final class PartParameterValues extends BasicEnum {
    const STR = "string";
    const NUM = "numeric";

    public static function toArray(): array {
        return [
            self::STR,
            self::NUM
        ];
    }
}