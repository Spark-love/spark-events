<?php

declare(strict_types=1);

namespace HiEvents\Http\Actions\Events;

use HiEvents\DomainObjects\EventDomainObject;
use HiEvents\Http\Actions\BaseAction;
use HiEvents\Resources\Event\EventResource;
use HiEvents\Services\Handlers\Event\DTO\GetPublicEventsDTO;
use HiEvents\Services\Handlers\Event\GetPublicEventsHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetEventsPublicAction extends BaseAction
{
    public function __construct(
        private readonly GetPublicEventsHandler $getEventsHandler,
    )
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        // Fetch all public events without requiring authentication
        $events = $this->getEventsHandler->handle(
            GetPublicEventsDTO::fromArray([
                'queryParams' => $this->getPaginationQueryParams($request),  // Handle pagination if required
            ]),
        );

        return $this->filterableResourceResponse(
            resource: EventResource::class,
            data: $events,
            domainObject: EventDomainObject::class,
        );
    }
}
