<?php

namespace Wiredspast\HabboApiWrapperPhp\Param;

enum OrderDir
{
    case Ascending;
    case Descending;

    public function key(): string
    {
        return match($this) {
            OrderDir::Ascending => 'asc',
            OrderDir::Descending => 'desc'
        };
    }
}