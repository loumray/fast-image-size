<?php

/**
 * fast-image-size image type bmp
 * @package fast-image-size
 * @copyright (c) Marc Alexander <admin@m-a-styles.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FastImageSize\Image;

class TypeBmp extends TypeBase
{
	protected $type = IMAGETYPE_BMP;

	/** @var int BMP header size needed for retrieving dimensions */
	const BMP_HEADER_SIZE = 26;

	/** @var string BMP signature */
	const BMP_SIGNATURE = "\x42\x4D";

	/** qvar int BMP dimensions offset */
	const BMP_DIMENSIONS_OFFSET = 18;

	protected $headerlength = self::BMP_HEADER_SIZE;

	public function extractSize()
	{
		return unpack('lwidth/lheight', $this->getHeaderPart(self::BMP_DIMENSIONS_OFFSET, 2 * self::LONG_SIZE));
	}

	public function getSignature()
	{
		return $this->getHeaderPart(0, 2);
	}

	public function isSignatureMatch()
	{
		return $this->getSignature() === self::BMP_SIGNATURE;
	}
}
