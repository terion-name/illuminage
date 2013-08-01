Illuminage
==========

Illuminage is a wrapper for the Imagine library to hook into the Laravel framework. It implements elegant shortcuts around Imagine and a smart cache system.

```php
// This will create a cropped 200x300 thumb, cache it, and display it in an image tag
echo Illuminage::thumb('image.jpg', 200, 300)

// Shortcut
echo Illuminage::square('image.jpg', 300)

// This will resize image to specified dimensions, cache it, and display it in an image tag
echo Illuminage::resize('image.jpg', 200, 300)

// This will **proportionaly** resize image to fit the specified dimensions, cache it, and display it in an image tag
echo Illuminage::fit('image.jpg', 200, 300)
```

What you get from those calls are not direct HTML strings but objects implementing the [HtmlObject\Tag](https://github.com/Anahkiasen/html-object) abstract, so you can use all sorts of HTML manipulation methods on them :

```php
$thumb = Illuminage::square('image.jpg', 200)->addClass('image-wide');
$thumb = $thumb->wrapWith('figure')->id('avatar');

echo $thumb;
// <figure id="avatar"><img class="image-wide" src="pathToThumbnail.jpg"></figure>
```

To get the URL of generated image:
```php
echo $thumb->getPath();
```

You can at all time access the Image instance used to render the images and use the Imagine methods:
```php
$thumb = Illuminage::image('foo.jpg');

echo $thumb->grayscale()->onImage(function($image) {
  $image->flipVertically()->rotate(45);
});
```

## Installation

* Add **"anahkiasen/illuminage":"dev-master"** in "require" section of composer.json
* Run command **composer update**
* Add **'Illuminage\IlluminageServiceProvider'** in providers list in config/app.php
* Add **'Illuminage' => 'Illuminage\Facades\Illuminage'** in aliases list in config/app.php
* Run commands **php artisan asset:publish** and **php artisan config:publish anahkiasen/illuminage**