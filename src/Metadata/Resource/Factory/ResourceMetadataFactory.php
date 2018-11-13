<?php

declare(strict_types=1);

namespace App\Metadata\Resource\Factory;

use App\Exception\ResourceClassNotFoundException;
use App\Metadata\Extractor\ExtractorInterface;
use App\Metadata\Resource\ResourceMetadata;

final class ResourceMetadataFactory implements ResourceMetadataFactoryInterface
{
    private $extractor;

    public function __construct(ExtractorInterface $extractor)
    {
        $this->extractor = $extractor;
    }

    /**
     * {@inheritdoc}
     */
    public function create(string $resourceClass): ResourceMetadata
    {
        if (!(class_exists($resourceClass) || interface_exists($resourceClass)) || !$resource = $this->extractor->getResources()[$resourceClass] ?? false) {
            throw new ResourceClassNotFoundException(sprintf('Resource "%s" not found.', $resourceClass));
        }

        return $resource;
    }

    public function getAllResourceMetadatas(): array
    {
        return $this->extractor->getResources();
    }
}
