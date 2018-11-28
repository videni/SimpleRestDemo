<?php

namespace Videni\Bundle\RestBundle\Collection\QueryVisitorExpression;

use Doctrine\ORM\Query\Expr;

/**
 * Represents logical OR expression.
 */
class OrCompositeExpression implements CompositeExpressionInterface
{
    /**
     * {@inheritdoc}
     */
    public function walkCompositeExpression(array $expressions)
    {
        return new Expr\Orx($expressions);
    }
}
