<?php

declare(strict_types=1);

namespace Compwright\GraphqlPhpJetpack;

use GraphQL\Language\AST\ArgumentNode;
use GraphQL\Language\AST\DirectiveNode;
use GraphQL\Language\AST\Node;
use GraphQL\Type\Definition\NamedType;
use GraphQL\Type\Definition\ResolveInfo;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * @property LoggerInterface $logger
 */
class DirectiveResolver implements LoggerAwareInterface
{
    use HandlerRegistryTrait;
    use LoggerAwareTrait;

    /** @var ?callable */
    protected $originalResolver;

    /**
     * @param ?callable $originalResolver
     */
    public function __construct($originalResolver = null)
    {
        $this->logger = new NullLogger();
        $this->originalResolver = $originalResolver;

        $this->registerHandler(new Directives\Callback());
        $this->registerHandler(new Directives\Lowercase());
        $this->registerHandler(new Directives\Uppercase());
    }

    /**
     * @param mixed $root
     * @param array<string, mixed> $args
     * @param mixed $context
     *
     * @return mixed
     */
    public function __invoke($root, array $args, $context, ResolveInfo $info)
    {
        if (is_callable($this->originalResolver)) {
            $root = ($this->originalResolver)($root, $args, $context, $info);
        }

        $directives = [];

        if ($info->fieldDefinition->astNode) {
            $directives = array_merge($directives, $this->readDirectives($info->fieldDefinition->astNode));
        }

        if ($info->fieldNodes[0]) {
            $directives = array_merge($directives, $this->readDirectives($info->fieldNodes[0]));
        }

        foreach ($directives as $directiveName => $directiveArgs) {
            if (array_key_exists($directiveName, $this->handlers)) {
                $directiveHandler = $this->handlers[$directiveName];
                if (is_callable($directiveHandler)) {
                    /** @var NamedType&callable $directiveHandler */
                    $this->logger->debug('Executing @' . $directiveName . ' (' . get_class($directiveHandler) . ') on ' . $info->fieldName);
                    $root = $directiveHandler($root, $directiveArgs, $context, $info);
                } else {
                    $this->logger->error('Found @' . $directiveName . ' directive on ' . $info->fieldName . ' but handler is not callable');
                }
            } else {
                $this->logger->warning('Found @' . $directiveName . ' directive on ' . $info->fieldName . ' but no handler is registered');
            }
        }

        return $root;
    }

    /**
     * @param Node $node
     *
     * @return array<string, array<string, mixed>>
     */
    protected function readDirectives($node): array
    {
        $directives = [];

        if (isset($node->directives)) {
            /** @var DirectiveNode $directive */
            foreach ($node->directives as $directive) {
                $args = [];

                /** @var ArgumentNode $arg */
                foreach ($directive->arguments as $arg) {
                    $args[$arg->name->value] = $arg->value->value ?? null;
                }

                $directives[$directive->name->value] = $args;
            }
        }

        return $directives;
    }
}
