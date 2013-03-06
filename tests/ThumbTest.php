<?php
use Illuminage\Thumb;

class ThumbTest extends IlluminageTests
{
  public function testCanCreateThumb()
  {
    $this->assertInstanceOf('Illuminage\Thumb', $this->thumb);
  }

  public function testCanCreateThumbViaStaticMethods()
  {
    $thumb = Thumb::square('foo.jpg', 200);

    $this->assertEquals('foo.jpg', $thumb->getImage());
    $this->assertEquals(200, $thumb->getWidth());
    $this->assertEquals(200, $thumb->getHeight());
  }

  public function testCanAccessProperties()
  {
    $this->assertEquals('foo.jpg', $this->thumb->getImage());
    $this->assertEquals(100, $this->thumb->getWidth());
    $this->assertEquals(100, $this->thumb->getHeight());
  }

  public function testCanGetFullPathToImage()
  {
    $this->assertEquals(__DIR__.'/public/foo.jpg', $this->thumb->getImagePath());
  }

  public function testCanRenderThumb()
  {
    $this->assertEquals('<img src="http://test/public/d49d9f3c769ee076be9ef21ec23f57d6.jpg" />', $this->thumb->render());

    unlink($this->cache->getCachePathOf($this->thumb));
  }

  public function testCanRenderThumbOnStringHint()
  {
    $this->assertEquals('<img src="http://test/public/d49d9f3c769ee076be9ef21ec23f57d6.jpg" />', (string) $this->thumb);

    unlink($this->cache->getCachePathOf($this->thumb));
  }
}