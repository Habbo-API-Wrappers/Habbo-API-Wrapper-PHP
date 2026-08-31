<?php

namespace Wiredspast\HabboApiWrapperPhp\AddOn\LevelUp;

class ExponentialLevelUpper extends AbstractLevelUpper
{
    private readonly float $strengthAsDecimal;
    private readonly int $maxXpValue;

    public function __construct(
        private readonly int $initialXp,
        int $strength,
        private readonly int $maximumLevel
    ) {
        $this->strengthAsDecimal = $strength/100;
        $this->maxXpValue = $this->xpForLevel($this->maximumLevel);
    }

    public function currentLevel(int $xp): int
    {
        $currentXp = $this->currentXp($xp);
        if ($currentXp <= 0) return 1;

        $logBase = 1 + $this->strengthAsDecimal;
        $level = (int) (log(($currentXp * $this->strengthAsDecimal / $this->initialXp) + 1) / log($logBase));

        if ($level > $this->maximumLevel) return $this->maximumLevel;
        if ($level < 1) return 1;
        if ($currentXp < $this->xpForLevel($level)) return max($level - 1, 1);
        if ($currentXp >= $this->xpForLevel($level + 1)) return min($this->maximumLevel, $level + 1);
        return $level;
    }

    public function totalXpRequired(int $xp): int
    {
        if ($this->isMaxed($xp)) return 0;
        $currentLevel = $this->currentLevel($xp);
        return $this->xpForLevel($currentLevel + 1) - $this->xpForLevel($currentLevel);
    }

    public function progress(int $xp): int
    {
        $currentXp = $this->currentXp($xp);
        if ($this->isMaxed($currentXp)) return 0;
        $currentLevel = $this->currentLevel($xp);
        return $currentXp - $this->xpForLevel($currentLevel);
    }

    public function progressPercentage(int $xp): int
    {
        $currentXp = $this->currentXp($xp);
        if ($this->isMaxed($currentXp)) return 0;
        $currentLevel = $this->currentLevel($xp);
        $levelXp = $this->xpForLevel($currentLevel);
        $nextLevelXp = $this->xpForLevel($currentLevel + 1);
        if ($levelXp == $nextLevelXp) return 100;
        return (int) ((($currentXp - $levelXp) / ($nextLevelXp - $levelXp)) * 100);
    }

    public function xpRemaining(int $xp): int
    {
        $currentXp = $this->currentXp($xp);
        if ($this->isMaxed($currentXp)) return 0;
        return $this->xpForLevel($this->currentLevel($currentXp) + 1) - $currentXp;
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
        return $this->maxXpValue;
    }

    private function xpForLevel(int $level): int
    {
        if ($level < 1) return 0;
        if ($level > $this->maximumLevel) return $this->maxXpValue;
        return (int) ($this->initialXp * ((pow(1 + $this->strengthAsDecimal, $level - 1) - 1 + 1e-9) / $this->strengthAsDecimal));
    }
}