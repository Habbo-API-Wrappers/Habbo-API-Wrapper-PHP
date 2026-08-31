<?php

namespace Wiredspast\HabboApiWrapperPhp\AddOn\LevelUp;

class LinearLevelUpper extends AbstractLevelUpper
{
    public function __construct(
        private readonly int $stepSize,
        private readonly int $maximumLevel,
    ) {}

    public function currentLevel(int $xp): int
    {
        return min($this->maximumLevel, 1 + $this->currentXp($xp) / $this->stepSize);
    }

    public function totalXpRequired(int $xp): int
    {
        if ($this->isMaxed($xp)) return 0;
        return $this->stepSize;
    }

    public function progress(int $xp): int
    {
        if ($this->isMaxed($xp)) return 0;
        return $this->currentXp($xp) % $this->stepSize;
    }

    public function progressPercentage(int $xp): int
    {
        if ($this->isMaxed($xp)) return 0;
        return (int) (((float) $this->progress($xp) / (float) $this->stepSize) * 100);
    }

    public function xpRemaining(int $xp): int
    {
        if ($this->isMaxed($xp)) return 0;
        return $this->stepSize - ($this->currentXp($xp) % $this->stepSize);
    }

    public function isMaxed(int $xp): bool
    {
        return $this->currentLevel($xp) >= $this->maximumLevel;
    }

    public function maxLevel(): int
    {
        return $this->maximumLevel;
    }

    public function maxXp(): int
    {
        return $this->maximumLevel * $this->stepSize;
    }
}
