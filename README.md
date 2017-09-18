# A faster getimagesize

[![Build Status](https://img.shields.io/travis/loumray/fastimagesize/master.svg?style=flat-square)](https://travis-ci.org/loumray/fastimagesize)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/loumray/fastimagesize.svg?style=flat-square)](https://scrutinizer-ci.com/g/loumray/fastimagesize/?branch=master)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Packagist Version](https://img.shields.io/packagist/v/loumray/fastimagesize.svg?style=flat-square)](https://packagist.org/packages/loumray/fastimagesize)
[![Quality Score](https://img.shields.io/scrutinizer/g/loumray/fastimagesize.svg?style=flat-square)](https://scrutinizer-ci.com/g/loumray/fastimagesize)

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

PHP 5.3.0 or greater.

### Installation

```
  composer require loumray/fastimagesize
```

### Usage

```
array \FastImageSize\getimagesize(String filepath);
```

Return array as per [PHP getimagesize function](http://php.net/manual/en/function.getimagesize.php)

Index 0 and 1 contains respectively the width and the height of the image. 

Index 2 is one of the [IMAGETYPE_XXX](http://php.net/manual/en/image.constants.php) constants indicating the type of the image.

Index 3 is a text string with the correct *height="yyy" width="xxx"* string that can be used directly in an IMG tag.

*mime* is the correspondant MIME type of the image.

It will however not return *channels* and *bits* index that getimagesize sometimes returns.

Just like for PHP getimagesize, you can pass any local or remote image to this library as long as it's readable.

### Backward Compatibility

For backward compatibility, the FastImageSize class is still available. So you can still make use of
```
$FastImageSize = new \FastImageSize\FastImageSize();

$imageSize = $FastImageSize->getImageSize(String filepath);
```
And this will return the array size

```
array(
  'width' => 16,
  'height' => 16,
  'type' => IMAGETYPE_PNG,
);
```
