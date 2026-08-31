<?php

namespace Wiredspast\HabboApiWrapperPhp\Resources;

use Psr\Http\Client\ClientExceptionInterface;
use Wiredspast\HabboApiWrapperPhp\DataTypes\Achievements\AchievementsResult;
use Wiredspast\HabboApiWrapperPhp\DataTypes\Achievements\UserAchievementsResult;
use Wiredspast\HabboApiWrapperPhp\Exceptions\HabboApiException;

/**
 * Allows access to the endpoints for achievements
 */
class AchievementsResource extends AbstractResource
{
    /**
     * Retrieves a list of all achievements including their details and level requirements.
     *
     * @return AchievementsResult A list of achievements with their details and level requirements.
     *
     * @throws HabboApiException If the API throws an error or exception
     * @throws ClientExceptionInterface If the wrapper fails to connect to the API
     */
    public function all(): AchievementsResult
    {
        $data = $this->transporter->get('/api/public/achievements');
        return AchievementsResult::fromArray($data);
    }

    /**
     * Retrieves a list of achievements for a user based on their unique ID.
     *
     * @param string $id The unique ID of the user whose achievements are to be retrieved.
     *
     * @return UserAchievementsResult A list of achievements for the specified user.
     *
     * @throws HabboApiException If the API throws an error or exception
     * @throws ClientExceptionInterface If the wrapper fails to connect to the API
     */
    public function forUser(string $id): UserAchievementsResult
    {
        $data = $this->transporter->get("/api/public/achievements/$id");
        return UserAchievementsResult::fromArray($data);
    }
}