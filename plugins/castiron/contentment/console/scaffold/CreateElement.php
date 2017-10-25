<?php

namespace Castiron\Contentment\Console\Scaffold;

use October\Rain\Scaffold\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class CreateElement extends GeneratorCommand
{
    protected $name = 'create:element';

    protected $description = "Creates a new Content Element";

    protected $stubs = [
        'element/element.stub' => 'content/{{studly_name}}.php',
        'element/default.stub' => 'content/{{lower_name}}/default.htm',
        'element/preview.stub' => 'content/{{lower_name}}/preview.htm',
        'element/fields.stub'  => 'content/{{lower_name}}/fields.yaml',
    ];

    protected function prepareVars()
    {
        $parts = explode('.', $this->argument('plugin'));
        $pluginName = array_pop($parts);
        $authorName = array_pop($parts);

        $modelName = $this->argument('elementName');
        $vars = [
            'name' => $modelName,
            'author' => $authorName,
            'plugin' => $pluginName
        ];
        return $vars;
    }

    public function fire()
    {
        parent::fire();

        $modelName = $this->vars['name'];

        $code = <<<CODE
use Castiron\Contentment\Content\Manager as ContentManager;

ContentManager::registerElement({$modelName}::class, [
    'icon' => 'icon-something',
    'label' => 'Some Label'
]);
CODE;

        $this->info(sprintf('Successfully generated Element named "%s"', $modelName));
        $this->info('');
        $this->comment("Don't forget to add something like this to your Plugin.php file.");
        $this->info('');

        $this->comment($code);
    }

    /**
     * Get the source file path.
     *
     * @return string
     */
    protected function getSourcePath()
    {
        return parent::getSourcePath().'/templates';
    }


    protected function getArguments()
    {
        return [
            ['plugin', InputArgument::REQUIRED, 'The name of the plugin. Eg: RainLab.Blog'],
            ['elementName', InputArgument::REQUIRED, 'The name of the element. Eg: OrderedList'],
        ];
    }

    protected function getOptions()
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Overwrite existing files with generated ones.'],
        ];
    }
}
