<?php

namespace Castiron\Contentment\Tests\Unit;

use Castiron\Contentment\Models\Content;
use Castiron\Contentment\Tests\Dummy\Complex;
use Castiron\Contentment\Tests\Dummy\Rendered;
use Castiron\Contentment\Tests\Dummy\Text;
use Castiron\Contentment\Tests\TestCase;
use Cms\Classes\Controller;
use Cms\Classes\Theme;
use Event;
use Illuminate\Support\Facades\Config;

class ContentTest extends TestCase
{
    protected $resetPlugins = ['Castiron.Contentment'];

    public function setUp()
    {
        parent::setUp();
        Text::unboot();


        $base = $this->app->basePath();
        $this->app->setThemesPath($base.'/plugins/castiron/contentment/tests/fixtures/themes');

        Config::set('cms.activeTheme', 'test');
        Event::flush('cms.activeTheme');
        Theme::resetCache();
    }

    public function testInstantiated()
    {
        new Content();
    }

    public function testInstantiatedWithType()
    {
        new Content(['element_type' => Text::class]);
    }

    public function testInstantiatedWithData()
    {
        static::textCE();
    }

    public function testNoEventsWhenInstantiating()
    {
        $element = static::textCE()->element();
        $this->assertCount(0, $element->events);
    }

    public function testEventsFired()
    {
        $content = static::textCE();
        $element = $content->element();
        $content->save();
        $this->assertContains('saving', $element->events);
        $this->assertContains('saved', $element->events);
        $this->assertContains('model.saveInternal', $element->events);
        $this->assertContains('model.afterSave', $element->events);
        $content->delete();
        $this->assertContains('deleting', $element->events);
        $this->assertContains('deleted', $element->events);
    }

    public function testChangeContents()
    {
        $content = static::textCE();
        $str = 'new data here';
        $content->setData(['body' => $str]);
        $this->assertSame($str, $content->element()->render());
        $content->save();
    }

    public function testComplexElements()
    {
        $content = static::complexCE();
        $str = 'new data here';
        $content->setData(['someValue' => $str]);
        $this->assertSame($str, $content->element()->render());
        $content->save();
    }

    /**
     * @expectedException \October\Rain\Database\ModelException
     */
    public function testValidation()
    {
        $content = static::complexCE();
        $content->setData(['someValue' => 'tooshort']);
        $content->save();
    }

    public function testRenderingWithTwig()
    {
        $content = static::renderedCE();
        $r = $content->render();
        $this->assertContains('###apple###', $r);
        $this->assertContains('###banana###', $r);
        $this->assertContains('###orange###', $r);
    }

    protected static function textCE()
    {
        return new Content([
            'element_type' => Text::class,
            'data' => Text::sampleData()
        ]);
    }

    protected static function complexCE()
    {
        return new Content([
            'element_type' => Complex::class,
            'data' => Complex::sampleData(),
        ]);
    }

    protected static function renderedCE()
    {
        return new Content([
            'element_type' => Rendered::class,
            'data' => Rendered::sampleData(),
        ]);
    }

}
