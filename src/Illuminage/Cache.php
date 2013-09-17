<?php
namespace Illuminage;

use Illuminate\Support\Facades\File;
/**
 * Handles caching and fetching of images
 */
class Cache
{

  /**
   * The Illuminage instance
   *
   * @var Illuminage
   */
  protected $illuminage;

  /**
   * Create an Illuminage Cache instance
   *
   * @param Illuminage $illuminage
   */
  public function __construct(Illuminage $illuminage)
  {
    $this->illuminage = $illuminage;
  }

  /**
   * Get the cache hash of an image
   *
   * @param Image $image
   *
   * @return string
   */
  public function getHashOf(Image $image)
  {
    $imagePath = $image->getOriginalImagePath();

    // Build the salt array
    $salts   = $image->getSalts();
    $salts[] = $image->getQuality();
    $salts[] = md5($imagePath);
    $salts   = serialize($salts);

    // Get image extension
    $extension = pathinfo($imagePath, PATHINFO_EXTENSION);

    return md5($salts).'.'.$extension;
  }

  /**
   * Get the path where an image will be cached
   *
   * @param Image $image
   *
   * @return string
   */
	public function getCachePathOf(Image $image)
	{
		$hash = $this->getHashOf($image);
		$cacheFolder = $this->illuminage->getCacheFolder();
		$hashedFolder = $cacheFolder . $this->getHashedPath($hash);

		if ( $hashedFolder and ! File::isDirectory($hashedFolder) ) @File::makeDirectory($hashedFolder,511,true);



		return $hashedFolder . $hash;
	}

	/**
	 * get hashed path with subfolders in case random_folder = true
	 *
	 * @param $hash
	 * @return string
	 */
	public function getHashedPathOf(Image $image){

		$hash = $this->getHashOf($image);

		return $this->getHashedPath($hash) . $hash;
	}

	/**
	 * get hashed folder with subfolders in case random_folder = true
	 *
	 * @param $hash
	 * @return string
	 */
	public function getHashedPath($hash){

		if ($this->illuminage->getOption('random_folder')) {
			return substr($hash, 0, 2) . '/' . substr($hash, 2, 2). '/';
		}

		return '';
	}

	/**
   * Check if an image is in cache
   *
   * @param Image $image
   *
   * @return boolean
   */
  public function isCached(Image $image)
  {
    return file_exists($this->getCachePathOf($image));
  }

}
