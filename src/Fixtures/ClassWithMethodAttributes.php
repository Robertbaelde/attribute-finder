<?php

namespace Robertbaelde\AttributeFinder\Fixtures;


final class ClassWithMethodAttributes
{
    #[SomeAttribute]
    public function someMethod()
    {

    }

    #[SomeAttribute]
    public function someOtherMethod()
    {

    }
}
