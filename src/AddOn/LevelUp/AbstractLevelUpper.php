<?php

namespace Wiredspast\HabboApiWrapperPhp\AddOn\LevelUp;

/**
 * Mimics the behaviour of the Variable Add-on: Level-up System
 */
abstract class AbstractLevelUpper
{
    /**
     * Bound the value to within the allowed XP limits
     *
     * @param int $xp The value of the variable
     *
     * @return int The bound XP value
     */
    public function currentXp(int $xp): int
    {
        return min(max($xp, 0), $this->maxXp());
    }

    /**
     * Get the current level for the given xp
     *
     * @param int $xp The value of the variable
     *
     * @return int The current level
     */
    public abstract function currentLevel(int $xp): int;

    /**
     * Get the total amount of XP required to achieve the next level from the current level
     *
     * @param int $xp The value of the variable
     *
     * @return int The total amount of XP required to achieve the next level
     */
    public abstract function totalXpRequired(int $xp): int;

    /**
     * Get the amount of XP past the current level
     *
     * @param int $xp The value of the variable
     *
     * @return int The amount of XP past the current level
     */
    public abstract function progress(int $xp): int;

    /**
     * Get the percentage of progress to the next level
     *
     * @param int $xp The value of the variable
     *
     * @return int The percentage of progress to the next level
     */
    public abstract function progressPercentage(int $xp): int;

    /**
     * Get the amount of XP required to reach the next level
     *
     * @param int $xp The value of the variable
     *
     * @return int The amount of XP required to reach the next level
     */
    public abstract function xpRemaining(int $xp): int;

    /**
     * Returns whether the variable has reached the max level or not
     *
     * @param int $xp The value of the variable
     *
     * @return bool Whether the variable has reached the max level or not
     */
    public abstract function isMaxed(int $xp): bool;

    /**
     * Get the maximum achievable level
     *
     * @return int The maximum achievable level
     */
    public abstract function maxLevel(): int;

    /**
     * Get the maximum achievable XP
     *
     * @return int The maximum achievable XP
     */
    public abstract function maxXp(): int;
}
