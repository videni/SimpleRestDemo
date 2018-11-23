<?php

namespace App\Bundle\RestBundle\Util;

use App\Bundle\RestBundle\Request\RequestType;
use Oro\Component\ChainProcessor\AbstractMatcher;
use Oro\Component\ChainProcessor\ExpressionParser;

class RequestExpressionMatcher extends AbstractMatcher
{
    /**
     * @param mixed       $value
     * @param RequestType $requestType
     *
     * @return bool
     */
    public function matchValue($value, RequestType $requestType)
    {
        return $this->isMatch(
            ExpressionParser::parse($value),
            $requestType,
            null
        );
    }
}