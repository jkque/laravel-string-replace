<?php

namespace Jkque\LaravelStringReplace\Tests;

use Orchestra\Testbench\TestCase;
use Jkque\LaravelStringReplace\LaravelStringReplaceServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [LaravelStringReplaceServiceProvider::class];
    }
    
    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
