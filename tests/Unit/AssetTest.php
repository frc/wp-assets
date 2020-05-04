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

        $this->assertEquals($this->uri . '/asset.xyz123.js', (string)$this->factory()->asset('asset.js'));
        $this->assertEquals($this->uri . '/asset.xyz123.js', (string)$this->factory()->asset('asset.js', true));

        $this->assertEquals($this->uri . '/empty.js', (string)$this->factory()->asset('empty.js'));
        $this->assertEquals($this->uri . '/empty.js', (string)$this->factory()->asset('empty.js', true));

        $this->assertEquals($this->uri . '/versioned.js?id=Gd7QEn4R81', (string)$this->factory()->asset('versioned.js'));
        $this->assertEquals($this->uri . '/versioned.js?id=Gd7QEn4R81', (string)$this->factory()->asset('versioned.js', true));

        $this->assertEquals($this->uri . '/main.js?id=a91004e635bd357e16e6', (string)$this->factory()->asset('main.js'));
        $this->assertEquals($this->uri . '/main.hash.a91004e635bd357e16e6.js', (string)$this->factory()->asset('main.js', true));

        $this->assertEquals($this->uri . '/hashed.tV5g5FDFBp.js', (string)$this->factory()->asset('hashed.js'));
        $this->assertEquals($this->uri . '/hashed.tV5g5FDFBp.js', (string)$this->factory()->asset('hashed.js', true));
    }

    /** @test */
    public function it_should_return_asset_path()
    {
        $this->assertEquals($this->path . DIRECTORY_SEPARATOR . 'asset.xyz123.js', $this->factory()->asset('asset.js')->path());
        $this->assertEquals($this->path . DIRECTORY_SEPARATOR . 'asset.xyz123.js', $this->factory()->asset('asset.js', true)->path());

        $this->assertEquals($this->path . DIRECTORY_SEPARATOR . 'empty.js', $this->factory()->asset('empty.js')->path());
        $this->assertEquals($this->path . DIRECTORY_SEPARATOR . 'empty.js', $this->factory()->asset('empty.js', true)->path());

        $this->assertEquals($this->path . DIRECTORY_SEPARATOR . 'versioned.js', $this->factory()->asset('versioned.js')->path());
        $this->assertEquals($this->path . DIRECTORY_SEPARATOR . 'versioned.js', $this->factory()->asset('versioned.js', true)->path());

        $this->assertEquals($this->path . DIRECTORY_SEPARATOR . 'main.js', $this->factory()->asset('main.js')->path());
        $this->assertEquals($this->path . DIRECTORY_SEPARATOR . 'main.js', $this->factory()->asset('main.js', true)->path());

        $this->assertEquals($this->path . DIRECTORY_SEPARATOR . 'hashed.tV5g5FDFBp.js', $this->factory()->asset('hashed.js')->path());
        $this->assertEquals($this->path . DIRECTORY_SEPARATOR . 'hashed.tV5g5FDFBp.js', $this->factory()->asset('hashed.js', true)->path());
    }

    /** @test */
    public function it_should_check_exists()
    {
        $this->assertEquals(true, $this->factory()->asset('file.js')->exists());
        $this->assertEquals(true, $this->factory()->asset('file.js', true)->exists());

        $this->assertEquals(true, $this->factory()->asset('versioned.js')->exists());
        $this->assertEquals(true, $this->factory()->asset('versioned.js', true)->exists());

        $this->assertEquals(true, $this->factory()->asset('main.js')->exists());
        $this->assertEquals(true, $this->factory()->asset('main.js', true)->exists());

        $this->assertEquals(true, $this->factory()->asset('hashed.js')->exists());
        $this->assertEquals(true, $this->factory()->asset('hashed.js', true)->exists());

    }

    public function it_should_not_exist() {
        $this->assertEquals(false, $this->factory()->asset('asset.js')->exists());
        $this->assertEquals(false, $this->factory()->asset('asset.js', true)->exists());

        $this->assertEquals(false, $this->factory()->asset('empty.js')->exists());
        $this->assertEquals(false, $this->factory()->asset('empty.js', true)->exists());
    }


    /** @test */
    public function it_should_get_contents()
    {
        $this->assertStringContainsString('console.log', $this->factory()->asset('file.js')->contents());
        $this->assertStringContainsString('console.log', $this->factory()->asset('file.js', true)->contents());

        $this->assertStringContainsString('console.log', $this->factory()->asset('versioned.js')->contents());
        $this->assertStringContainsString('console.log', $this->factory()->asset('versioned.js', true)->contents());

        $this->assertStringContainsString('console.log', $this->factory()->asset('hashed.js')->contents());
        $this->assertStringContainsString('console.log', $this->factory()->asset('hashed.js', true)->contents());

        $this->assertStringContainsString('console.log', $this->factory()->asset('main.js')->contents());
        $this->assertStringContainsString('console.log', $this->factory()->asset('main.js', true)->contents());
    }
}
