<?php

namespace Jkque\StringReplace;

use Illuminate\Console\GeneratorCommand;

class StringReplaceCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'string-replace:pipe {name} {model? : With model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new pipe class for more complex string replace';
   
    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Pipe';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        if ($this->argument('model')) {
            return realpath(__DIR__.'/stubs/string-replace-with-model.stub');
        }
        
        return realpath(__DIR__.'/stubs/string-replace.stub');
    }

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $model = $this->argument('model');

        if ($model) {
            $nameSpace = config('string-replace.model_namespace').$model;
        
            $replace = ['DummyModelNamespace', 'DummyModel', 'dummyModel'];
            $replacement = [$nameSpace, $model, strtolower($model)];
    
            return str_replace(
                $replace, $replacement, parent::buildClass($name)
            );
        }
        
        $stub = $this->files->get($this->getStub());

        return $this->replaceNamespace($stub, $name)->replaceClass($stub, $name);
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\StringReplace';
    }
}
