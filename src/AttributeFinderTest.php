<?php

namespace Robertbaelde\AttributeFinder;

use PHPUnit\Framework\TestCase;
use Robertbaelde\AttributeFinder\Fixtures\AnotherAttribute;
use Robertbaelde\AttributeFinder\Fixtures\ClassWithAnotherAttribute;
use Robertbaelde\AttributeFinder\Fixtures\ClassWithAttribute;
use Robertbaelde\AttributeFinder\Fixtures\ClassWithMethodAttributes;
use Robertbaelde\AttributeFinder\Fixtures\SomeAttribute;

final class AttributeFinderTest extends TestCase
{
    /** @test */
    public function it_finds_all_class_attributes()
    {
        $attributes = AttributeFinder::inClasses([ClassWithAttribute::class, ClassWithAnotherAttribute::class])
            ->findAll();

        $this->assertCount(2, $attributes);
    }

    /** @test */
    public function it_finds_class_attributes_with_name()
    {
        $attributes = AttributeFinder::inClasses([ClassWithAttribute::class, ClassWithAnotherAttribute::class])
            ->withName(SomeAttribute::class)
            ->findAll();

        $this->assertCount(1, $attributes);
        $this->assertInstanceOf(ClassAttribute::class, $attributes[0]);
    }

    /** @test */
    public function it_finds_class_attributes_with_names()
    {
        $attributes = AttributeFinder::inClasses([ClassWithAttribute::class, ClassWithAnotherAttribute::class])
            ->withName(SomeAttribute::class)
            ->withName(AnotherAttribute::class)
            ->findAll();

        $this->assertCount(2, $attributes);

        $attributes = AttributeFinder::inClasses([ClassWithAttribute::class, ClassWithAnotherAttribute::class])
            ->withNames(SomeAttribute::class, AnotherAttribute::class)
            ->findAll();

        $this->assertCount(2, $attributes);
    }

    /** @test */
    public function it_can_find_method_attributes()
    {
        $attributes = AttributeFinder::inClasses([ClassWithMethodAttributes::class])
            ->findAll();
        $this->assertCount(2, $attributes);
    }

    /** @test */
    public function it_only_finds_class_attributes()
    {
        $attributes = AttributeFinder::inClasses([ClassWithAttribute::class, ClassWithAnotherAttribute::class, ClassWithMethodAttributes::class])
            ->findClassAttributes();
        $this->assertCount(2, $attributes);
        $this->assertContainsOnlyInstancesOf(ClassAttribute::class, $attributes);
    }

    /** @test */
    public function it_only_finds_method_attributes()
    {
        $attributes = AttributeFinder::inClasses([ClassWithAttribute::class, ClassWithAnotherAttribute::class, ClassWithMethodAttributes::class])
            ->findMethodAttributes();
        $this->assertCount(2, $attributes);
        $this->assertContainsOnlyInstancesOf(MethodAttribute::class, $attributes);
    }
}
