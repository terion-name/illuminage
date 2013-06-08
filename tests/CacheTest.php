<?php
include '_start.php';

use Illuminage\Facades\Illuminage;

class CacheTest extends IlluminageTests
{

  public function testCanComputeHashOfThumb()
  {
    $this->assertEquals($this->hash, $this->cache->getHashOf($this->thumb));
  }

  public function testSameImageWithDifferentNameGetsSameHash()
  {
    $thumb = Illuminage::thumb('foocopy.jpg', 100, 100);

    $this->assertEquals($this->hash, $this->cache->getHashOf($thumb));
  }

  public function testCanComputeCorrectExtension()
  {
    $thumb = Illuminage::thumb('bar.png', 100, 100);

    $this->assertEquals('537f44bda1ecd3ff75ed2a3229cbb855.png', $this->cache->getHashOf($thumb));
  }

  public function testCanGetPathToCache()
  {
    $this->assertEquals('tests/public/'.$this->hash, $this->cache->getCachePathOf($this->thumb));
  }

  public function testCanCheckIfAThumbIsCached()
  {
    $path = $this->cache->getCachePathOf($this->thumb);

    $this->assertFalse($this->cache->isCached($this->thumb));
    file_put_contents($path, 'foo');
    $this->assertTrue($this->cache->isCached($this->thumb));

    unlink($path);
  }
}
