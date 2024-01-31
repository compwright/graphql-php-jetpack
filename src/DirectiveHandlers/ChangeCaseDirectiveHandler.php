<?php

declare(strict_types=1);

namespace Compwright\GraphqlPhpJetpack\DirectiveHandlers;

use GraphQL\Type\Definition\ResolveInfo;
use Compwright\GraphqlPhpJetpack\Execution\ExecutorInterface;

class ChangeCaseDirectiveHandler implements ExecutorInterface
{
    /**
     * @inheritdoc
     */
    public function __invoke($root, array $args, $context, ResolveInfo $info)
    {
        if (is_string($root)) {
            switch ($args['case'] ?? null) {
                case 'upper':
                    return strtoupper($root);
                case 'lower':
                    return strtolower($root);
            }
        }

        return $root;
    }
}
