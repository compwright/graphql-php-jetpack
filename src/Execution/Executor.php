<?php

declare(strict_types=1);

namespace Compwright\GraphqlPhpJetpack\Execution;

use GraphQL\Type\Definition\ResolveInfo;

abstract class Executor implements ExecutorInterface
{
    protected ExecutorLoader $loader;

    public function __construct(ExecutorLoader $loader)
    {
        $this->loader = $loader;
    }

    /**
     * @inheritdoc
     */
    abstract public function __invoke($root, array $args, $context, ResolveInfo $info);
}
