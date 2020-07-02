<?php

namespace Jkque\StringReplace;

use Illuminate\Pipeline\Pipeline;

class StringReplace implements StringReplacePipe
{
    use Conditionable;

    protected static $content;

    protected $pipes = [];

    protected $variables = [];

    protected $stripTags = true;

    public function variables(array $variables) 
    {
        $this->variables = $variables;

        return $this;
    }
    
    public function with($pipes)
    {
        if (is_array($pipes)) {
            collect($pipes)->whereInstanceOf(StringReplacePipe::class)->merge($this->pipes);
        }

        if ($pipes instanceof StringReplacePipe) {
            $this->pipes[] = $pipes;
        }

        return $this;
    }

    public static function content(&$content)
    {
        static::$content = $content;

        return new static;
    }

    public function replace()
    {
        return $this->replaceContent();
    }

    public function stripTags(bool $strip = true)
    {
        $this->stripTags = $strip;

        return $this;
    }

    protected function replaceContent()
    {
        collect($this->variables)->each(function ($variable, $key) {
            static::$content = str_replace($key, $variable, static::$content);

            if ($this->stripTags) {
                static::$content = strip_tags(static::$content);
            }
        });

        return app(Pipeline::class)
            ->send(static::$content)
            ->through($this->pipes)
            ->then(function ($content) {
                return $content;
            });
    }

    public function handle($content, callable $next)
    {
        collect($this->variables)->each(function ($variable, $key) use(&$content) {
            $content = str_replace($key, $variable, $content);

            if ($this->stripTags) {
                $content = strip_tags($content);
            }
        });

        return $next($content);
    }
}
