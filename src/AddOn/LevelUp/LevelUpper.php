<?php

namespace Wiredspast\HabboApiWrapperPhp\AddOn\LevelUp;

class LevelUpper
{
    /**
     * Create a new linear Level Up system
     *
     * @param int $stepSize The amount of XP required for each level
     * @param int $maxLevel The maximum level
     *
     * @return AbstractLevelUpper A linear level upper
     */
    public static function linear(int $stepSize, int $maxLevel): AbstractLevelUpper
    {
        return new LinearLevelUpper($stepSize, $maxLevel);
    }

    /**
     * Create a new interpolating Level Up system
     *
     * @param array<int, int> $levelToXpMap The configuration of the add-on
     *
     * @return AbstractLevelUpper An interpolating level upper
     */
    public static function interpolate(array $levelToXpMap): AbstractLevelUpper
    {
        return new InterpolateLevelUpper($levelToXpMap);
    }

    /**
     * Create a new exponential Level Up system
     *
     * @param int $initialXp The required XP to reach level 2 from level 1
     * @param int $strength The exponential increase factor (%)
     * @param int $maxLevel The maximum level
     *
     * @return AbstractLevelUpper An exponential level upper
     */
    public static function exponential(int $initialXp, int $strength, int $maxLevel): AbstractLevelUpper
    {
        return new ExponentialLevelUpper($initialXp, $strength, $maxLevel);
    }
}