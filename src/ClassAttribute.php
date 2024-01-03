<?php

namespace Robertbaelde\AttributeFinder;

final readonly class ClassAttribute
{
    /**
     * @param class-string $class
     */
    public function __construct(
        public object $attribute,
        public string $class,
    )
    {
    }
}
