<?php

declare(strict_types=1);

namespace App\Metadata\Resource\Factory;

use App\Exception\ResourceClassNotFoundException;
use App\Metadata\Resource\ResourceMetadata;

/**
 * Creates a resource metadata value object.
 */
interface ResourceMetadataFactoryInterface
{
    /**
     * Creates a resource metadata.
     *
     *
     * @throws ResourceClassNotFoundException
     */
    public function create(string $resourceClass): ResourceMetadata;

    public function getAllResourceMetadatas(): array;
}
