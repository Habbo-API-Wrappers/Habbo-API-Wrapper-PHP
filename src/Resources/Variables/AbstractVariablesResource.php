<?php

namespace Wiredspast\HabboApiWrapperPhp\Resources\Variables;

use Wiredspast\HabboApiWrapperPhp\Http\Transporter;
use Wiredspast\HabboApiWrapperPhp\Resources\AbstractResource;

/**
 * The base for a variable endpoint resource
 */
abstract class AbstractVariablesResource extends AbstractResource
{
    /**
     * @param int $roomId The ID of the room
     * @param Transporter $transporter The HTTP transporter
     */
    public function __construct(
        protected int $roomId,
        Transporter $transporter
    ) {
        parent::__construct($transporter);
    }
}