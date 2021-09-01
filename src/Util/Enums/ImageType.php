<?php
namespace App\Util\Enums;

final class ImageType extends BasicEnum {
    const LOGO = "iclogo";
    const TEMP = "temp";
    const PART = "part";
    const STORAGE = "storagelocation";
    const FOOTPRINT = "footprint";

    public static function toArray(): array {
        return [
            self::LOGO,
            self::TEMP,
            self::PART,
            self::STORAGE,
            self::FOOTPRINT
        ];
    }

}