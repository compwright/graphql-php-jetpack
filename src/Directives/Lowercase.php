<?php

declare(strict_types=1);

namespace Compwright\GraphqlPhpJetpack\Directives;

use GraphQL\Type\Definition\ResolveInfo;

class Lowercase extends DirectiveType
{
    public function __construct()
    {
        $this->name = 'lowercase';
        $this->description = 'Make text lowercase';
    }

    /**
     * @inheritdoc
     */
    public function __invoke($root, array $args, $context, ResolveInfo $info)
    {
        return strtolower((string) $root);
    }
}
