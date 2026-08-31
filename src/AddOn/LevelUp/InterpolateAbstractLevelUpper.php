<?php

namespace Wiredspast\HabboApiWrapperPhp\AddOn\LevelUp;

class InterpolateAbstractLevelUpper extends AbstractLevelUpper
{
    private array $xpToLevel;

    public function __construct(array $levelToXpMap)
    {
        $this->xpToLevel = array_map(
            function ($level) use ($levelToXpMap) {
                return [ "level" => $level, "xp" => $levelToXpMap[$level] ];
            },
            array_keys($levelToXpMap)
        );

        usort(
            $this->xpToLevel,
            function ($left, $right) {
                return $left['xp'] < $right['xp'] ? -1 : ($left['xp'] > $right['xp'] ? 1 : 0);
            }
        );
    }

    public function currentLevel(int $xp): int
    {
        return $this->findProgressInfo($xp)['currentLevel'];
    }

    public function totalXpRequired(int $xp): int
    {
        $info = $this->findProgressInfo($xp);
        return $info['nextLevelXp'] - $info['currentLevelXp'];
    }

    public function progress(int $xp): int
    {
        $info = $this->findProgressInfo($xp);
        return $info['currentXp'] - $info['currentLevelXp'];
    }

    public function progressPercentage(int $xp): int
    {
        $info = $this->findProgressInfo($xp);
        $totalRequired = $info['nextLevelXp'] - $info['currentLevelXp'];
        if ($totalRequired == 0) return 0;
        return (int) ((($info['currentXp'] - $info['currentLevelXp']) / $totalRequired) * 100);
    }

    public function xpRemaining(int $xp): int
    {
        $info = $this->findProgressInfo($xp);
        return $info['nextLevelXp'] - $info['currentXp'];
    }

    public function isMaxed(int $xp): bool
    {
        return $this->findProgressInfo($xp)['isMaxed'];
    }

    public function maxLevel(): int
    {
        return $this->findProgressInfo($this->maxXp())['currentLevel'];
    }

    public function maxXp(): int
    {
        if (sizeof($this->xpToLevel) == 0) return 0;
        return $this->xpToLevel[sizeof($this->xpToLevel) - 1]['xp'];
    }

    private function findProgressInfo(int $xp): array
    {
        if (sizeof($this->xpToLevel) == 0) {
            return [
                "currentLevel" => 1,
                "currentLevelXp" => 0,
                "currentXp" => 0,
                "nextLevelXp" => 0,
                "isMaxed" => true
            ];
        }

        $currentXp = $this->currentXp($xp);
        $last = end($this->xpToLevel);
        if ($currentXp >= $last['xp']) {
            return [
                "currentLevel" => $last['level'],
                "currentLevelXp" => $last['xp'],
                "currentXp" => $last['xp'],
                "nextLevelXp" => $last['xp'],
                "isMaxed" => true
            ];
        }

        $floor = [ "level" => 1, "xp" => 0 ];
        $ceil = reset($this->xpToLevel);
        for ($i = 0; $i < sizeof($this->xpToLevel); $i++) {
            $entry = $this->xpToLevel[$i];
            if ($entry['xp'] <= $currentXp) {
                $floor = $entry;
                continue;
            }
            $ceil = $entry;
            break;
        }

        $levelDifference = $ceil['level'] - $floor['level'];
        $xpDifference = $ceil['xp'] - $floor['xp'];
        $xpPerLevel = $xpDifference / $levelDifference;
        $interpolationProgress = $currentXp - $floor['xp'];
        $levelSteps = min(
            max(
                (int) ($interpolationProgress / $xpPerLevel),
                0
            ),
            $levelDifference - 1
        );

        $currentLevel = $floor['level'] + $levelSteps;
        $currentLevelXp = $floor['xp'] + (int) ($xpPerLevel * $levelSteps);

        if ($levelSteps == $levelDifference - 1) {
            $nextLevelXp = $ceil['xp'];
        } else {
            $nextLevelXp = $floor['xp'] + (int) ($xpPerLevel * ($levelSteps + 1));
            if ($currentXp >= $nextLevelXp) {
                $levelSteps += 1;
                $currentLevel = $floor['level'] + $levelSteps;
                $currentLevelXp = $floor['xp'] + (int) ($xpPerLevel * $levelSteps);
                $nextLevelXp = $levelSteps == $levelDifference
                    ? $ceil['xp']
                    : $floor['xp'] + (int) ($xpPerLevel * ($levelSteps + 1));
            }
        }

        return [
            "currentLevel" => $currentLevel,
            "currentLevelXp" => $currentLevelXp,
            "currentXp" => $currentXp,
            "nextLevelXp" => $nextLevelXp,
            "isMaxed" => false,
        ];
    }
}