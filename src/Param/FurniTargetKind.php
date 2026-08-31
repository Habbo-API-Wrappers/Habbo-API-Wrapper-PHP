<?php

namespace Wiredspast\HabboApiWrapperPhp\Param;

enum FurniTargetKind
{
    case Furni;
    case FurniBC;
    case WallItems;
    case WallItemsBC;

    public function key(): string
    {
        return match($this) {
            FurniTargetKind::Furni => 'furni',
            FurniTargetKind::FurniBC => 'furni-bc',
            FurniTargetKind::WallItems => 'wall-items',
            FurniTargetKind::WallItemsBC => 'wall-items-bc'
        };
    }
}