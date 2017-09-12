<?php

/**
 * fast-image-size image type wbmp
 * @package fast-image-size
 * @copyright (c) Marc Alexander <admin@m-a-styles.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FastImageSize\Image;

class TypeWbmp extends TypeBase
{
	protected $type = IMAGETYPE_WBMP;
	
	protected $headerlength = self::LONG_SIZE;
	
	public function extractSize()
	{
		$size = unpack('Cwidth/Cheight', $this->getHeaderPart(self::SHORT_SIZE, self::SHORT_SIZE));

		// Check if dimensions are valid. A file might be recognised as WBMP
		// rather easily (see extra check for JPEG2000).
		if (!$this->validDimensions($size)) {
			return false;
		}

		return $size;
	}

	public function getSignature()
	{
		return $this->getHeaderPart();
	}

	/**
	 * Return if supplied data might be part of a valid WBMP file
	 *
	 * @return bool True if data might be part of a valid WBMP file, else false
	 */
	public function isSignatureMatch()
	{
		$signature = $this->getSignature();

		return ord($signature[0]) === 0 && ord($signature[1]) === 0 && $signature !== substr(TypeJp2::JPEG_2000_SIGNATURE, 0, self::LONG_SIZE);
	}

	/**
	 * Return whether dimensions are valid
	 *
	 * @param array $size Size array
	 *
	 * @return bool True if dimensions are valid, false if not
	 */
	protected function validDimensions($size)
	{
		return $size['height'] > 0 && $size['width'] > 0;
	}
}
