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
        // Execute ARGUMENT_DEFINITION directives pre-resolve
        foreach ($info->fieldDefinition->args as $argDefinition) {
            if (!$argDefinition->astNode) {
                continue;
            }
            $argDirectives = $this->readDirectives($argDefinition->astNode);
            foreach ($argDirectives as $directiveName => $directiveArgs) {
                $argName = $argDefinition->name;
                if (array_key_exists($directiveName, $this->handlers)) {
                    $directiveHandler = $this->handlers[$directiveName];
                    if (is_callable($directiveHandler)) {
                        /** @var NamedType&callable $directiveHandler */
                        $this->logger->debug('Executing @' . $directiveName . ' (' . get_class($directiveHandler) . ') on ' . $argName);
                        $args[$argName] = $directiveHandler($args[$argName], $directiveArgs, $context, $info);
                    } else {
                        $this->logger->error('Found @' . $directiveName . ' directive on ' . $argName . ' but handler is not callable');
                    }
                } else {
                    $this->logger->warning('Found @' . $directiveName . ' directive on ' . $argName . ' but no handler is registered');
                }
            }
        }

        if (is_callable($this->originalResolver)) {
            $root = ($this->originalResolver)($root, $args, $context, $info);
        }

        // Execute FIELD_DEFINITION directives post-resolve
        $fieldDirectives = [];
        if ($info->fieldDefinition->astNode) {
            $fieldDirectives = array_merge($fieldDirectives, $this->readDirectives($info->fieldDefinition->astNode));
        }
        if ($info->fieldNodes[0]) {
            $fieldDirectives = array_merge($fieldDirectives, $this->readDirectives($info->fieldNodes[0]));
        }
        foreach ($fieldDirectives as $directiveName => $directiveArgs) {
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
