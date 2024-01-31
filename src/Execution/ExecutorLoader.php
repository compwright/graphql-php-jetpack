<?php

declare(strict_types=1);

namespace Compwright\GraphqlPhpJetpack\Execution;

use Compwright\GraphqlPhpJetpack\Execution\ExecutorInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Container\ContainerExceptionInterface;

abstract class ExecutorLoader
{
    protected ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Get the executor name from parameters and loads it via a container
     *
     * @param mixed $args
     *
     * @throws NotFoundExceptionInterface  No entry was found for **this** identifier.
     * @throws ContainerExceptionInterface Error while retrieving the entry.
     */
    public function __invoke(...$args): ExecutorInterface
    {
        return $this->container->get(
            $this->getClassName(...$args)
        );
    }

    abstract protected function getClassName(): string;
}
