<?php
declare(strict_types=1);

namespace App\Serializer;

use App\Operation\OperationType;
use App\Exception\RuntimeException;
use App\Metadata\Resource\Factory\ResourceMetadataFactoryInterface;
use App\Utils\AttributesExtractor;
use Symfony\Component\HttpFoundation\Request;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\DeserializationContext;
use JMS\Serializer\Context;

/**
 * {@inheritdoc}
 *
 */
final class SerializerContextBuilder implements SerializerContextBuilderInterface
{
    private $resourceMetadataFactory;

    public function __construct(ResourceMetadataFactoryInterface $resourceMetadataFactory)
    {
        $this->resourceMetadataFactory = $resourceMetadataFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function createFromRequestAttributes(bool $normalization, array $attributes): Context
    {
        $resourceMetadata = $this->resourceMetadataFactory->create($attributes['resource_class']);

        $context = $normalization ? new SerializationContext(): new DeserializationContext();

        $key = $normalization ? 'normalization_context' : 'denormalization_context';

        $operationKey = null;
        $operationType = null;
        $groups = null;

        if (isset($attributes['collection_operation_name'])) {
            $operationKey = 'collection_operation_name';
            $operationType = OperationType::COLLECTION;

            $groups = $resourceMetadata->getCollectionOperationAttribute($attributes[$operationKey], $key, [], true);

        } else {
            $operationKey = 'item_operation_name';
            $operationType = OperationType::ITEM;

            $groups = $resourceMetadata->getItemOperationAttribute($attributes[$operationKey], $key, [], true);
        }

        if (isset($groups['groups'])) {
            $context->setGroups($groups['groups']);
        }

        $context->setAttribute($operationKey, $attributes[$operationKey]);
        $context->setAttribute('operation_type', $operationType);

        if (!$normalization && !isset($context['api_allow_update'])) {
            $context->setAttribute('api_allow_update', \in_array($request->getMethod(), ['PUT', 'PATCH'], true));
        }

        $context->setAttribute('resource_class', $attributes['resource_class']);
        $context->setAttribute('request_uri', $request->getRequestUri());
        $context->setAttribute('uri', $request->getUri());

        return $context;
    }
}
