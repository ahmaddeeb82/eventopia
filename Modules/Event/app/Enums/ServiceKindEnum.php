<?php

namespace Modules\Event\Enums;

enum ServiceKindEnum : string
{
    case PRIVATE = 'private';
    case PUBLIC = 'public';

    public static function getTypes(){
        return [
            self::PRIVATE, self::PUBLIC
        ];
    }
}
