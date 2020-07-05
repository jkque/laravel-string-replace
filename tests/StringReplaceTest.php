<?php

namespace Jkque\StringReplace\Tests;

use Jkque\StringReplace\StringReplace;
use Orchestra\Testbench\TestCase;
use Jkque\StringReplace\StringReplaceServiceProvider;

class StringReplaceTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [StringReplaceServiceProvider::class];
    }
    
    /** @test */
    public function it_can_replace_string()
    {
        $string = '@name is awesome <p>in php</p> replacethis';

        $user = new User;

        $string = StringReplace::content($string)
            ->when($user, function ($string) use($user) {
                return $string->with(new UserStringReplace($user));
            })
            ->variables([
                'replacethis' => 'coding',
            ])
            ->replace();
                
        $this->assertSame('John Doe is awesome in php coding', $string);
    }
    
    /** @test */
    public function it_can_add_file()
    {
        $this->artisan('string-replace:pipe', ['name' => 'RemoveBadWords'])->assertExitCode(0);
    }
}

class User 
{
    public $name;

    public function __construct()
    {
        $this->name = 'John Doe';
    }
}

class UserStringReplace extends StringReplace
{
    public function __construct(User $user)
    {
        $this->variables([
            '@name' => $user->name,
        ]);
    }
}
