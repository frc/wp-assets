<?php

namespace Tests\Unit;

use Frc\WP\Assets\Factory;
use Tests\TestCase;

class AssetTest extends TestCase
{
    protected $path = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'stubs';

    protected $uri = 'http//www.test.app/assets';

    protected function factory()
    {
        return Factory::make(
            $this->path . DIRECTORY_SEPARATOR . 'asset-manifest.json',
            $this->uri,
            $this->path
        );
    }

    /** @test */
    public function it_should_return_asset_uri()
    {
        $asset = (string) $this->factory()->asset('asset.js');
        $asset2 = (string) $this->factory()->asset('empty.js');

        $this->assertEquals($this->uri.'/asset.xyz123.js', $asset);
        $this->assertEquals($this->uri.'/empty.js', $asset2);
    }

    /** @test */
    public function it_should_return_asset_path()
    {
        $this->assertEquals(
            $this->path . DIRECTORY_SEPARATOR . 'asset.xyz123.js',
            $this->factory()->asset('asset.js')->path()
        );
    }

    /** @test */
    public function it_should_check_exists()
    {
        $this->assertEquals(
            true,
            $this->factory()->asset('file.js')->exists()
        );
    }

    /** @test */
    public function it_should_check_exists_with_query_string()
    {
        $this->assertEquals(
            true,
            $this->factory()->asset('versioned.js')->exists()
        );
    }

    /** @test */
    public function it_should_get_contents()
    {
        $this->assertStringContainsString(
            'console.log',
            $this->factory()->asset('file.js')->contents()
        );
    }

    /** @test */
    public function it_should_get_contents_with_query()
    {
        $this->assertStringContainsString(
            'console.log',
            $this->factory()->asset('versioned.js')->contents()
        );
    }
}
