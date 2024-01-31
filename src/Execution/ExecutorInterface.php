<?php

declare(strict_types=1);

namespace Compwright\GraphqlPhpJetpack\Execution;

use GraphQL\Type\Definition\ResolveInfo;

interface ExecutorInterface
{
    /**
     * @param mixed $root
     * @param array<string, mixed> $args
     * @param mixed $context
     *
     * @return mixed
     */
    public function __invoke($root, array $args, $context, ResolveInfo $info);
}
