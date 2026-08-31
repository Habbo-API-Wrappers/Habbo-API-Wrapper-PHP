<?php

namespace Wiredspast\HabboApiWrapperPhp\DataTypes\Users\Rooms;

class Room
{
    /**
     * @param int $id The ID of the room
     * @param string $name The name of the room
     * @param string $description The description of the room
     * @param string $creationTime When the room was created
     * @param string|null $habboGroupId The UUID of the group linked to the room if it exists
     * @param string[] $tags The tags assigned to the room
     * @param int $maximumVisitors The maximum amount of visitors allowed in the room
     * @param bool $showOwnerName Whether the owners name shows in game
     * @param string $ownerName The name of the room owner
     * @param string $ownerUniqueId The UUID of the room owner
     * @param string[] $categories The categories assigned to the room
     * @param string $thumbnailUrl The URL to the thumbnail of the room
     * @param string $imageUrl The URL to a rendered image of the room
     * @param int $rating The rating of the room
     * @param string $uniqueId The UUID of the room
     */
    public function __construct(
        public int $id,
        public string $name,
        public string $description,
        public string $creationTime,
        public ?string $habboGroupId,
        public array $tags,
        public int $maximumVisitors,
        public bool $showOwnerName,
        public string $ownerName,
        public string $ownerUniqueId,
        public array $categories,
        public string $thumbnailUrl,
        public string $imageUrl,
        public int $rating,
        public string $uniqueId
    ) {}

    /**
     * Parse a received array to a Room instance
     *
     * @param array $data The received array
     *
     * @return self The parsed Room instance
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            description: $data['description'],
            creationTime: $data['creationTime'],
            habboGroupId: $data['habboGroupId'] ?? null,
            tags: $data['tags'],
            maximumVisitors: $data['maximumVisitors'],
            showOwnerName: $data['showOwnerName'],
            ownerName: $data['ownerName'],
            ownerUniqueId: $data['ownerUniqueId'],
            categories: $data['categories'],
            thumbnailUrl: $data['thumbnailUrl'],
            imageUrl: $data['imageUrl'],
            rating: $data['rating'],
            uniqueId: $data['uniqueId']
        );
    }
}