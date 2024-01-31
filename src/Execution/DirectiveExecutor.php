<?php

declare(strict_types=1);

namespace Compwright\GraphqlPhpJetpack\Execution;

use Compwright\GraphqlPhpJetpack\Utils;
use GraphQL\Type\Definition\ResolveInfo;

class DirectiveExecutor extends Executor
{
    /**
     * @inheritdoc
     */
    public function __invoke($root, array $args, $context, ResolveInfo $info)
    {
        $directives = [];

        if ($info->fieldDefinition->astNode) {
            $directives = array_merge($directives, Utils::readDirectives($info->fieldDefinition->astNode));
        }

        if ($info->fieldNodes[0]) {
            $directives = array_merge($directives, Utils::readDirectives($info->fieldNodes[0]));
        }

        foreach ($directives as $directiveName => $directiveArgs) {
            $directiveHandler = $this->loader->__invoke($directiveName);
            $root = $directiveHandler($root, $directiveArgs, $context, $info);
        }

        return $root;
    }
}
