<?php


declare(strict_types=1);

namespace App\Metadata\Extractor;

use App\InvalidArgumentException;

/**
 * Extracts an array of metadata from a file or a list of files.
 *
 */
interface ExtractorInterface
{
    /**
     * Parses all metadata files and convert them in an array.
     *
     * @throws InvalidArgumentException
     */
    public function getResources(): array;
}
