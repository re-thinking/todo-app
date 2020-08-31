<?php

namespace App\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use App\Todo\Domain\Service\Validation;
use Symfony\Component\DependencyInjection\Reference;

class ValidatorPass implements CompilerPassInterface
{
    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has(Validation\ServiceInterface::class)) {
            return;
        }

        $definition = $container->findDefinition(Validation\ServiceInterface::class);

        // find all service IDs with the app.mail_transport tag
        $taggedServices = $container->findTaggedServiceIds('todo.task.validator');

        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('addValidator', [new Reference($id)]);
        }
    }
}