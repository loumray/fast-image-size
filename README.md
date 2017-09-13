# A faster getimagesize

[![Build Status](https://travis-ci.org/loumray/fastimagesize.svg?branch=master)](https://travis-ci.org/loumray/fastimagesize)

This package provides a getimagesize function that aims to match the usage of [PHP getimagesize](http://php.net/manual/en/function.getimagesize.php) while trying to avoid the performance cost of downloading the complete file.

It currently supports the following image types:

* BMP
* GIF
* ICO
* IFF
* JPEG 2000
* JPEG
* PNG
* PSD
* TIF/TIFF
* WBMP

### Requirements

PHP 5.3.0 or newer is required for this library to work. But, using a supported PHP version is higly recommended.

### Installation

Via composer, run:
```
  composer require loumray/fastimagesize
```

### Usage

```
array \FastImageSize\getimagesize(String filename);
```

Return array as per [PHP getimagesize function](http://php.net/manual/en/function.getimagesize.php)

Index 0 and 1 contains respectively the width and the height of the image. 

Index 2 is one of the [IMAGETYPE_XXX](http://php.net/manual/en/image.constants.php) constants indicating the type of the image.

Index 3 is a text string with the correct *height="yyy" width="xxx"* string that can be used directly in an IMG tag.

*mime* is the correspondant MIME type of the image.

It will however not return *channels* and *bits* index that getimagesize sometimes returns.

Just like for PHP getimagesize, you can pass any local or remote image to this library as long as it's readable.

### License

[The MIT License (MIT)](http://opensource.org/licenses/MIT)
