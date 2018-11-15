<?php

declare(strict_types=1);

namespace App\Routing\PathResolver;

use App\Operation\OperationType;
use App\Exception\InvalidArgumentException;
use App\Operation\PathSegmentNameGeneratorInterface;

/**
 * Generates an operation path.
 */
final class OperationPathResolver implements OperationPathResolverInterface
{
    private $pathSegmentNameGenerator;

    public function __construct(PathSegmentNameGeneratorInterface $pathSegmentNameGenerator)
    {
        $this->pathSegmentNameGenerator = $pathSegmentNameGenerator;
    }

    /**
     * {@inheritdoc}
     */
    public function resolveOperationPath(string $resourceShortName, array $operation, $operationType, string $operationName = null): string
    {
        if (isset($operation['path'])) {
            return $operation['path'];
        }

        $path = '/'.$this->pathSegmentNameGenerator->getSegmentName($resourceShortName, true);

        if (OperationType::ITEM === $operationType) {
            $path .= '/{id}';
        }

        return $path;
    }
}
