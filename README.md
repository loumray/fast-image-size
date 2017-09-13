# fast-image-size library

[![Build Status](https://travis-ci.org/loumray/fast-image-size.svg?branch=master)](https://travis-ci.org/loumray/fast-image-size)

### About

fast-image-size is a PHP library that does almost everything PHP's getimagesize() does but without the large overhead of downloading the complete file.

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

PHP 5.3.0 or newer is required for this library to work. But, using a supported PHP version is recommended.

### Installation

It is recommend to install the library using composer.
Just add the following snippet to your composer.json:
```
  "require": {
    "loumray/fast-image-size": "2.*"
  },
```

### Usage

fast-image-size match usage of PHP getimagesize
```
$size = \FastImageSize\getimagesize('https://example.com/some_random_image.jpg');
```
Return array matching what [PHP getimagesize function](http://php.net/manual/en/function.getimagesize.php) will return

Index 0 and 1 contains respectively the width and the height of the image. 

It will however not return channels and bits index that getimagesize returns.

As for the PHP function, you can pass any local or remote image to this library as long as it's readable.

### Automated Tests

The library is being tested using unit tests to prevent possible issues.

### License

[The MIT License (MIT)](http://opensource.org/licenses/MIT)
