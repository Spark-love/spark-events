<?php

namespace HiEvents\Services\Handlers\Event;

use HiEvents\DomainObjects\EventSettingDomainObject;
use HiEvents\DomainObjects\ImageDomainObject;
use HiEvents\DomainObjects\OrganizerDomainObject;
use HiEvents\Repository\Eloquent\Value\Relationship;
use HiEvents\Repository\Interfaces\EventRepositoryInterface;
use HiEvents\Services\Handlers\Event\DTO\GetPublicEventsDTO; // Updated to use the new DTO
use Illuminate\Pagination\LengthAwarePaginator;

class GetPublicEventsHandler
{
    public function __construct(private readonly EventRepositoryInterface $eventRepository)
    {
    }

    public function handle(GetPublicEventsDTO $dto): LengthAwarePaginator
    {
        // Load necessary relations (images, settings, organizer) for public events
        return $this->eventRepository
            ->loadRelation(new Relationship(ImageDomainObject::class))
            ->loadRelation(new Relationship(EventSettingDomainObject::class))
            ->loadRelation(new Relationship(
                domainObject: OrganizerDomainObject::class,
                name: 'organizer',
            ))
            ->findEvents(
                where: [], // No account_id, fetch public events
                params: $dto->queryParams
            );
    }
}
