<?php

declare(strict_types=1);

namespace Compwright\GraphqlPhpJetpack\Execution;

use GraphQL\Executor\Executor;
use GraphQL\Type\Definition\ResolveInfo;

class DefaultFieldResolver implements ExecutorInterface
{
    /**
     * @inheritdoc
     */
    public function __invoke($root, array $args, $context, ResolveInfo $info)
    {
        return Executor::defaultFieldResolver($root, $args, $context, $info);
    }
}
