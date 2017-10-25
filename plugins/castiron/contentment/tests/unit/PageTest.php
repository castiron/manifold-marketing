<?php namespace Castiron\Contentment\Tests\Unit;

use Castiron\Contentment\Tests\TestCase;
use Config;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Class PageTest
 * @package Castiron\Contentment\Tests\Unit
 */
class PageTest extends TestCase
{
    /**
     * Reset the DB after each test. THANKS LARAVEL I LOVE YOU!
     */
    use DatabaseTransactions;

    /**
     * @test
     */
    public function testSiteRootUsesDomainRootUrl() {
        Config::set('castiron.contentment::enableSiteRoot', true);

        $page = $this->page(true, [
            'title' => 'Fake page 123',
            'site_root' => 1,
        ]);

        $this->assertEquals('/', $page->getUrl());

        $page = $this->page(true, [
            'title' => 'Fake page 234',
            'site_root' => 0,
        ]);

        $this->assertEquals('/fake-page-234', $page->getUrl());
    }

    /**
     * @test
     */
    public function testSiteRootDoesNotUseDomainRootUrlWhenDisabled() {
        Config::set('castiron.contentment::enableSiteRoot', false);

        $page = $this->page(true, [
            'title' => 'Fake page 123',
            'site_root' => 0,
        ]);

        $this->assertEquals('/fake-page-123', $page->getUrl());

        $page = $this->page(true, [
            'title' => 'Fake page 234',
            'site_root' => 1,
        ]);

        $this->assertEquals('/fake-page-234', $page->getUrl());
    }

    /**
     * @test
     */
    public function testSiteRootAbsoluteUrlDoesNotContainEndingSlash() {
        Config::set('castiron.contentment::enableSiteRoot', true);

        $page = $this->page(true, [
            'title' => 'Fake page 123',
            'site_root' => 1,
        ]);

        $this->assertEquals('http://localhost', $page->getAbsoluteUrl());
    }
}
