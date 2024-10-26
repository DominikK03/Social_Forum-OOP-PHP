<?php

namespace app\Enum;

enum Role
{
    case user;
    case admin;
    case master;

    public static function fromName(string $name): ?self {
        foreach (self::cases() as $case) {
            if ($case->name === $name) {
                return $case;
            }
        }
        return null;
    }
}
