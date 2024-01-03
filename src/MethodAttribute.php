<?php

namespace Robertbaelde\AttributeFinder;

use ReflectionMethod;

final readonly class MethodAttribute
{
    public function __construct(
        public object $attribute,
        public ReflectionMethod $method
    ) {
    }
}
