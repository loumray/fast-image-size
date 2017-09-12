<?php

/**
 * fast-image-size image type ico
 * @package fast-image-size
 * @copyright (c) Marc Alexander <admin@m-a-styles.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FastImageSize\Image;

class TypeIco extends TypeBase
{
	protected $type = IMAGETYPE_ICO;

	/** @var string ICO reserved field */
	const ICO_RESERVED = 0;

	/** @var int ICO type field */
	const ICO_TYPE = 1;

	protected $headerlength = 2 * self::LONG_SIZE;

	public function extractSize()
	{
		return unpack('Cwidth/Cheight', $this->getHeaderPart(self::LONG_SIZE + self::SHORT_SIZE, self::SHORT_SIZE));
	}

	public function getSignature()
	{
		return $this->getHeaderPart();
	}

	public function isSignatureMatch()
	{
		// Get header
		$signatureArray = @unpack('vreserved/vtype/vimages', $this->getSignature());
		
		return $signatureArray['reserved'] === self::ICO_RESERVED && $signatureArray['type'] === self::ICO_TYPE && $signatureArray['images'] > 0 && $signatureArray['images'] <= 255;
	}
}
