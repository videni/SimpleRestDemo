<?php

declare(strict_types=1);

namespace App\Tests;

use ProxyManager\Proxy\VirtualProxyInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use App\Kernel;
use PSS\SymfonyMockerContainer\DependencyInjection\MockerContainer;

class TestKernel extends Kernel
{
     /**
     * {@inheritdoc}
     */
    public function shutdown(): void
    {
        if (false === $this->booted) {
            return;
        }

        if (!in_array($this->getEnvironment(), ['test', 'test_cached'], true)) {
            parent::shutdown();

            return;
        }

        $container = $this->getContainer();
        parent::shutdown();
        $this->cleanupContainer($container);
    }

    /**
     * Remove all container references from all loaded services
     *
     * @param ContainerInterface $container
     */
    protected function cleanupContainer(ContainerInterface $container): void
    {
        $containerReflection = new \ReflectionObject($container);
        $containerServicesPropertyReflection = $containerReflection->getProperty('services');
        $containerServicesPropertyReflection->setAccessible(true);

        $services = $containerServicesPropertyReflection->getValue($container) ?: [];
        foreach ($services as $serviceId => $service) {
            if (null === $service) {
                continue;
            }

            if (in_array($serviceId, $this->getServicesToIgnoreDuringContainerCleanup(), true)) {
                continue;
            }

            $serviceReflection = new \ReflectionObject($service);

            if ($serviceReflection->implementsInterface(VirtualProxyInterface::class)) {
                continue;
            }

            $servicePropertiesReflections = $serviceReflection->getProperties();
            $servicePropertiesDefaultValues = $serviceReflection->getDefaultProperties();
            foreach ($servicePropertiesReflections as $servicePropertyReflection) {
                $defaultPropertyValue = null;
                if (isset($servicePropertiesDefaultValues[$servicePropertyReflection->getName()])) {
                    $defaultPropertyValue = $servicePropertiesDefaultValues[$servicePropertyReflection->getName()];
                }

                $servicePropertyReflection->setAccessible(true);
                $servicePropertyReflection->setValue($service, $defaultPropertyValue);
            }
        }

        $containerServicesPropertyReflection->setValue($container, null);
    }

    protected function getContainerBaseClass(): string
    {
        return MockerContainer::class;
    }

    protected function getServicesToIgnoreDuringContainerCleanup(): array
    {
        return [
            'kernel',
            'http_kernel'
        ];
    }
}
