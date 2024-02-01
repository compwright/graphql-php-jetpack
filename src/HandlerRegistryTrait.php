<?php

declare(strict_types=1);

namespace Compwright\GraphqlPhpJetpack;

use GraphQL\Type\Definition\NamedType;

trait HandlerRegistryTrait
{
    /** @var NamedType[] */
    protected array $handlers = [];

    public function registerHandler(NamedType $type): self
    {
        $this->handlers[$type->name()] = $type;
        return $this;
    }
}
