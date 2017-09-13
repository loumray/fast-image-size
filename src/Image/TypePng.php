<?php

/**
 * fast-image-size image type png
 * @package fast-image-size
 * @copyright (c) Marc Alexander <admin@m-a-styles.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FastImageSize\Image;

class TypePng extends TypeBase
{
	/** @var string PNG header */
	const PNG_HEADER = "\x89\x50\x4e\x47\x0d\x0a\x1a\x0a";

	/** @var int PNG IHDR offset */
	const PNG_IHDR_OFFSET = 12;

	protected $type = IMAGETYPE_PNG;

	public function __construct($filepath)
	{
		parent::__construct($filepath);

		//Initializing here for backward compatibility
		// Retrieve image data including the header, the IHDR tag, and the
		// following 2 chunks for the image width and height
		$this->headerlength = self::PNG_IHDR_OFFSET + 3 * self::LONG_SIZE;
	}

	public function extractSize()
	{
		return unpack('Nwidth/Nheight', $this->getHeaderPart(self::PNG_IHDR_OFFSET + self::LONG_SIZE, self::LONG_SIZE * 2));
	}

	public function getSignature()
	{
		return $this->getHeaderPart(0, self::PNG_IHDR_OFFSET - self::LONG_SIZE);
	}

	public function isSignatureMatch()
	{
		return $this->getSignature() === self::PNG_HEADER && $this->getHeaderPart(self::PNG_IHDR_OFFSET, self::LONG_SIZE) === 'IHDR';
	}
}
