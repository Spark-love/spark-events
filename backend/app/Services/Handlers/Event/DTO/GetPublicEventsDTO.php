<?php

namespace HiEvents\Services\Handlers\Event\DTO;

use HiEvents\DataTransferObjects\BaseDTO;
use HiEvents\Http\DTO\QueryParamsDTO;

class GetPublicEventsDTO extends BaseDTO
{
    public function __construct(
        public QueryParamsDTO $queryParams, // Only pagination and filters
    )
    {
    }
}
