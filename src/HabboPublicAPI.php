<?php

namespace Wiredspast\HabboApiWrapperPhp;

use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Wiredspast\HabboApiWrapperPhp\Http\Transporter;
use Wiredspast\HabboApiWrapperPhp\Param\Hotel;
use Wiredspast\HabboApiWrapperPhp\Resources\AchievementsResource;
use Wiredspast\HabboApiWrapperPhp\Resources\BadgesResource;
use Wiredspast\HabboApiWrapperPhp\Resources\GameDataResource;
use Wiredspast\HabboApiWrapperPhp\Resources\GroupsResource;
use Wiredspast\HabboApiWrapperPhp\Resources\ListsResource;
use Wiredspast\HabboApiWrapperPhp\Resources\MarketPlaceResource;
use Wiredspast\HabboApiWrapperPhp\Resources\RoomsResource;
use Wiredspast\HabboApiWrapperPhp\Resources\UsersResource;
use Wiredspast\HabboApiWrapperPhp\Resources\Variables\VariablesResource;

class HabboPublicAPI
{
    private Transporter $transporter;
    private ?AchievementsResource $achievements = null;
    private ?BadgesResource $badges = null;
    private ?GroupsResource $groups = null;
    private ?MarketPlaceResource $marketplace = null;
    private ?RoomsResource $rooms = null;
    private ?ListsResource $lists = null;
    private ?UsersResource $users = null;

    private function __construct(
        string $baseDomain,
        ?ClientInterface $httpClient = null,
        ?RequestFactoryInterface $requestFactory = null,
        ?StreamFactoryInterface $streamFactory = null
    ) {
        $httpClient = $httpClient ?? Psr18ClientDiscovery::find();
        $requestFactory = $requestFactory ?? Psr17FactoryDiscovery::findRequestFactory();
        $streamFactory = $streamFactory ?? Psr17FactoryDiscovery::findStreamFactory();
        $this->transporter = new Transporter($baseDomain, $httpClient, $requestFactory, $streamFactory);
    }

    /**
     * Create an API wrapper for the given hotel
     */
    public static function fromHotel(
        Hotel $hotel,
        ?ClientInterface $httpClient = null,
        ?RequestFactoryInterface $requestFactory = null,
        ?StreamFactoryInterface $streamFactory = null
    ): self {
        return new self($hotel->getDomain(), $httpClient, $requestFactory, $streamFactory);
    }

    /**
     * Access the achievement related endpoints
     *
     * @return AchievementsResource
     */
    public function achievements(): AchievementsResource
    {
        return $this->achievements ??= new AchievementsResource($this->transporter);
    }

    /**
     * Access the badge related endpoints
     *
     * @return BadgesResource
     */
    public function badges(): BadgesResource
    {
        return $this->badges ??= new BadgesResource($this->transporter);
    }

    /**
     * Access the group related endpoints
     *
     * @return GroupsResource
     */
    public function groups(): GroupsResource
    {
        return $this->groups ??= new GroupsResource($this->transporter);
    }

    /**
     * Access the marketplace related endpoints
     *
     * @return MarketPlaceResource
     */
    public function marketplace(): MarketPlaceResource
    {
        return $this->marketplace ??= new MarketPlaceResource($this->transporter);
    }

    /**
     * Access the room related endpoints
     *
     * @return RoomsResource
     */
    public function rooms(): RoomsResource
    {
        return $this->rooms ??= new RoomsResource($this->transporter);
    }

    /**
     * Access the list related endpoints
     *
     * @return ListsResource
     */
    public function lists(): ListsResource
    {
        return $this->lists ??= new ListsResource($this->transporter);
    }

    /**
     * Access the user related endpoints
     *
     * @return UsersResource
     */
    public function users(): UsersResource
    {
        return $this->users ??= new UsersResource($this->transporter);
    }

    /**
     * Create a wrapper to access the variable endpoints for a specified room
     *
     * @param int $roomId The ID of the room
     * @param string $wiredReadKey The wired read header key
     * @param string $wiredWriteKey The wired write header key
     *
     * @return VariablesResource The wrapper to access variables for the specified room
     */
    public function variables(int $roomId, string $wiredReadKey, string $wiredWriteKey): VariablesResource
    {
        return new VariablesResource(
            $roomId,
            $this->transporter->extendWithHeaders([
                'X-Wired-Read-Key' => $wiredReadKey,
                'X-Wired-Write-Key' => $wiredWriteKey
            ])
        );
    }

    /**
     * Checks if the backend is available.
     *
     * @return bool Whether the backend is available or not.
     */
    public function ping(): bool
    {
        try {
            $this->transporter->get('/api/public/ping');
            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }
}