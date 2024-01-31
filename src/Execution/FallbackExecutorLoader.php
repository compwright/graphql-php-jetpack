<?php

declare(strict_types=1);

namespace Compwright\GraphqlPhpJetpack\Execution;

use Compwright\GraphqlPhpJetpack\Execution\ExecutorInterface;
use Compwright\GraphqlPhpJetpack\Execution\ExecutorLoader;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

abstract class FallbackExecutorLoader extends ExecutorLoader
{
    /** @var class-string<ExecutorInterface> */
    protected string $fallbackExecutorClass;

    /**
     * @param class-string<ExecutorInterface> $fallbackExecutorClass
     */
    public function __construct(ContainerInterface $container, string $fallbackExecutorClass)
    {
        parent::__construct($container);
        $this->fallbackExecutorClass = $fallbackExecutorClass;
    }

    public function __invoke(...$args): ExecutorInterface
    {
        try {
            return parent::__invoke(...$args);
        } catch (NotFoundExceptionInterface $e) {
            return $this->container->get($this->fallbackExecutorClass);
        }
    }
}
