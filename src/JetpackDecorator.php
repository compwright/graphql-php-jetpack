<?php

declare(strict_types=1);

namespace Compwright\GraphqlPhpJetpack;

use GraphQL\Language\AST\ScalarTypeDefinitionNode;
use GraphQL\Language\AST\TypeDefinitionNode;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * @property LoggerInterface $logger
 */
class JetpackDecorator implements LoggerAwareInterface
{
    use HandlerRegistryTrait;
    use LoggerAwareTrait;

    public function __construct()
    {
        $this->logger = new NullLogger();

        $this->registerHandler(new Scalars\BigInt());
        $this->registerHandler(new Scalars\Date());
        $this->registerHandler(new Scalars\DateTime());
        $this->registerHandler(new Scalars\DateTimeTz());
        $this->registerHandler(new Scalars\Email());
        $this->registerHandler(new Scalars\JSON());
        $this->registerHandler(new Scalars\Latitude());
        $this->registerHandler(new Scalars\Longitude());
        $this->registerHandler(new Scalars\MixedScalar());
        $this->registerHandler(new Scalars\NullScalar());
        $this->registerHandler(new Scalars\UsState());
        $this->registerHandler(new Scalars\UsZipcode());
    }

    /**
     * @param array<string, mixed> $config
     * @param array<string, mixed> $typeDefinitionMap
     *
     * @return array<string, mixed>
     */
    public function __invoke(array $config, TypeDefinitionNode $typeDefinition, array $typeDefinitionMap): array
    {
        $name = $config['name'];

        if ($typeDefinition instanceof ScalarTypeDefinitionNode) {
            if (array_key_exists($name, $this->handlers)) {
                $instance = $this->handlers[$name];
                $this->logger->debug('Attaching scalar ' . $name . ' handler ' . get_class($instance));
                $config['serialize'] = [$instance, 'serialize'];
                $config['parseValue'] = [$instance, 'parseValue'];
                $config['parseLiteral'] = [$instance, 'parseLiteral'];
            }
        }

        return $config;
    }
}
