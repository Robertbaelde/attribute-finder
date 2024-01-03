<?php

namespace Robertbaelde\AttributeFinder;

final class AttributeFinder
{
    private array $names;

    public function __construct(private array $classes)
    {
    }

    public static function inClasses(array $classes): self
    {
        return new self($classes);
    }

    public function withName(string $attributeName): self
    {
        $this->names[] = $attributeName;
        return $this;
    }

    public function withNames(string ...$names): self
    {
        foreach ($names as $name) {
            $this->withName($name);
        }

        return $this;
    }

    public function findAll(): array
    {
        $attributes = [];

        foreach ($this->classes as $class) {
            $reflectionClass = new \ReflectionClass($class);

            foreach ($reflectionClass->getAttributes() as $attribute) {
                if(!isset($this->names)){
                    $attributes[] = new ClassAttribute($attribute->newInstance(), $class);
                    continue;
                }

                if (in_array($attribute->getName(), $this->names)) {
                    $attributes[] = new ClassAttribute($attribute->newInstance(), $class);
                }
            }

            $methods = $reflectionClass->getMethods(\ReflectionMethod::IS_PUBLIC);
            foreach ($methods as $method) {
                foreach ($method->getAttributes() as $attribute) {
                    if(!isset($this->names)){
                        $attributes[] = new MethodAttribute($attribute->newInstance(), $method);
                        continue;
                    }

                    if (in_array($attribute->getName(), $this->names)) {
                        $attributes[] = new MethodAttribute($attribute->newInstance(), $method);
                    }
                }
            }
        }

        return $attributes;
    }


    /**
     * @return array<ClassAttribute>
     */
    public function findClassAttributes(): array
    {
        return array_values(array_filter($this->findAll(), fn($attribute) => $attribute instanceof ClassAttribute));
    }

    /**
     * @return array<MethodAttribute>
     */
    public function findMethodAttributes(): array
    {
        return array_values(array_filter($this->findAll(), fn($attribute) => $attribute instanceof MethodAttribute));
    }
}
