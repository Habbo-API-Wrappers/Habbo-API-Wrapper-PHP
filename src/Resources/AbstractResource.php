<?php

namespace Wiredspast\HabboApiWrapperPhp\Resources;

use Wiredspast\HabboApiWrapperPhp\Http\Transporter;

/**
 * The base for an endpoint resource
 */
abstract class AbstractResource
{
    public function __construct(
        protected Transporter $transporter
    ) {}
}