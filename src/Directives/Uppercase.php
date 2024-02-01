<?php

declare(strict_types=1);

namespace Compwright\GraphqlPhpJetpack\Directives;

use GraphQL\Type\Definition\ResolveInfo;

class Uppercase extends DirectiveType
{
    public function __construct()
    {
        $this->name = 'uppercase';
        $this->description = 'Make text uppercase';
    }

    /**
     * @inheritdoc
     */
    public function __invoke($root, array $args, $context, ResolveInfo $info)
    {
        return strtoupper((string) $root);
    }
}
