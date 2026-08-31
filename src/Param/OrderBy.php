<?php

namespace Wiredspast\HabboApiWrapperPhp\Param;

enum OrderBy
{
    case Value;
    case CreationTime;
    case UpdateTime;

    public function key(): string
    {
        return match($this) {
            OrderBy::Value => 'value',
            OrderBy::CreationTime => 'creation_time',
            OrderBy::UpdateTime => 'update_time'
        };
    }
}
