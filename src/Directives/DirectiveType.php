<?php

declare(strict_types=1);

namespace Compwright\GraphqlPhpJetpack\Directives;

use GraphQL\Language\AST\Node;
use GraphQL\Type\Definition\NamedType;
use GraphQL\Type\Definition\NamedTypeImplementation;
use GraphQL\Type\Definition\ResolveInfo;

abstract class DirectiveType implements NamedType
{
    use NamedTypeImplementation;

    /**
     * @param mixed $root
     * @param array<string, mixed> $args
     * @param mixed $context
     *
     * @return mixed
     */
    public function __invoke($root, array $args, $context, ResolveInfo $info)
    {
        return $root;
    }

    public function assertValid(): void
    {
    }

    public function astNode(): ?Node
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function extensionASTNodes(): array
    {
        return [];
    }
}
