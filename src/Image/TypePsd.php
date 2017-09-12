<?php

/**
 * fast-image-size image type psd
 * @package fast-image-size
 * @copyright (c) Marc Alexander <admin@m-a-styles.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FastImageSize\Image;

class TypePsd extends TypeBase
{
	/** @var string PSD signature */
	const PSD_SIGNATURE = "8BPS";

	/** @var int PSD header size */
	const PSD_HEADER_SIZE = 22;

	/** @var int PSD dimensions info offset */
	const PSD_DIMENSIONS_OFFSET = 14;

	protected $type = IMAGETYPE_PSD;

	protected $headerlength = self::PSD_HEADER_SIZE;

	public function extractSize()
	{
		return unpack('Nheight/Nwidth', $this->getHeaderPart(self::PSD_DIMENSIONS_OFFSET, 2 * self::LONG_SIZE));
	}

	public function getSignature()
	{
		return $this->getHeaderPart(0, self::LONG_SIZE);
	}

	public function isSignatureMatch()
	{
		//If current header size is smaller than needed size to match than not a match
		if (strlen($this->getHeaderPart()) < self::LONG_SIZE+2) {
			return false;
		}

		// Offset for version info is length of header but version is only a
		// 16-bit unsigned value
		$version = unpack('n', $this->getHeaderPart(self::LONG_SIZE, 2));

		return $this->getSignature() === self::PSD_SIGNATURE && $version[1] === 1;
	}
}
