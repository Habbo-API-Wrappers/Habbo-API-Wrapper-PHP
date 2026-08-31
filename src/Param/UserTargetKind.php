<?php

namespace Wiredspast\HabboApiWrapperPhp\Param;

enum UserTargetKind
{
    case Users;
    case Pets;
    case Bots;

    public function key(): string
    {
        return match ($this) {
            UserTargetKind::Users => 'users',
            UserTargetKind::Pets => 'pets',
            UserTargetKind::Bots => 'bots'
        };
    }
}