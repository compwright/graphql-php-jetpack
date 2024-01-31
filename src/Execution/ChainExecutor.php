<?php

declare(strict_types=1);

namespace Compwright\GraphqlPhpJetpack\Execution;

use GraphQL\Type\Definition\ResolveInfo;

class ChainExecutor implements ExecutorInterface
{
    /** @var ExecutorInterface[] */
    private array $executors;

    /**
     * @param ExecutorInterface $executors
     */
    public function __construct(...$executors)
    {
        $this->executors = $executors;
    }

    /**
     * @inheritdoc
     */
    public function __invoke($root, array $args, $context, ResolveInfo $info)
    {
        foreach ($this->executors as $executor) {
            $root = $executor($root, $args, $context, $info);
        }

        return $root;
    }
}
