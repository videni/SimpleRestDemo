<?php

declare(strict_types=1);

namespace App\Operation;

final class OperationType
{
    const ITEM = 'item';
    const COLLECTION = 'collection';
    const SUBRESOURCE = 'subresource';
    const TYPES = [self::ITEM, self::COLLECTION, self::SUBRESOURCE];
}
