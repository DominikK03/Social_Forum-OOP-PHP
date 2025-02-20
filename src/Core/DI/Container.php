<?php

namespace app\Core\DI;

use AllowDynamicProperties;
use app\Core\DI\Exception\ClassNotFoundException;

#[AllowDynamicProperties] class Container
{

    private array $config;
    private array $registry;
    private array $instances;
    private array $bindings;

    public function bindInterface(string $interface, string $class): self
    {
        $this->bindings[$interface] = $class;
        return $this;
    }

    public function setConfig(string $class, string $parameterName, mixed $value): self
    {
        $this->config[$class][$parameterName] = $value;
        return $this;
    }

    public function register(string ...$classes): self
    {
        foreach ($classes as $class) {
            $this->registry[$class] = $class;
        }
        return $this;
    }

    public function build(): self
    {
        foreach ($this->registry as $class) {
            if (!$this->has($class)) {
                $this->instances[$class] = $this->buildObject($class);
            }
        }
        return $this;
    }

    /**
     * @throws ClassNotFoundException
     */
    public function get(string $class): mixed
    {
        if (!$this->has($class)) {
            throw new ClassNotFoundException();
        }
        return $this->instances[$class];
    }

    public function has(string $class): bool
    {
        return isset($this->instances[$class]);
    }

    public function buildObject(string $class): mixed
    {
        if (interface_exists($class) && isset($this->bindings[$class])) {
            $class = $this->bindings[$class];
        }

        $reflectionClass = new \ReflectionClass($class);
        $constructor = $reflectionClass->getConstructor();

        if (is_null($constructor)) {
            return new $class;
        }

        $parameters = $constructor->getParameters();
        $dependencies = [];

        foreach ($parameters as $parameter) {
            $parameterType = $parameter->getType();

            if ($parameterType instanceof \ReflectionNamedType && !$parameterType->isBuiltin()) {
                $dependencyClass = $parameterType->getName();
                if ($this->has($dependencyClass)) {
                    $dependencies[] = $this->get($dependencyClass);
                } else {
                    $dependencies[] = $this->buildObject($dependencyClass);
                }
            } else {
                $parameterName = $parameter->getName();

                if (isset($this->config[$class][$parameterName])) {
                    $dependencies[] = $this->config[$class][$parameterName];
                } elseif ($parameter->isOptional()) {
                    $dependencies[] = $parameter->getDefaultValue();
                } else {
                    throw new \Exception("Cannot build");
                }
            }
        }
        return $reflectionClass->newInstanceArgs($dependencies);
    }
}