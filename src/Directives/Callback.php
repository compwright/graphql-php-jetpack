<?php

declare(strict_types=1);

namespace Compwright\GraphqlPhpJetpack\Directives;

use BadFunctionCallException;
use GraphQL\Type\Definition\ResolveInfo;

class Callback extends DirectiveType
{
    public function __construct()
    {
        $this->name = 'callback';
        $this->description = 'Execute a user-defined function';
    }

    /**
     * @inheritdoc
     *
     * @throws BadFunctionCallException
     */
    public function __invoke($root, array $args, $context, ResolveInfo $info)
    {
        if (!isset($args['fn']) || !is_callable($args['fn'])) {
            throw new BadFunctionCallException('Invalid fn argument');
        }

        return ($args['callback'])($root);
    }
}
