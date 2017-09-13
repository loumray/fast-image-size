<?php

/**
 * fast-image-size image type gif
 * @package fast-image-size
 * @copyright (c) Marc Alexander <admin@m-a-styles.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FastImageSize\Image;

class TypeGif extends TypeBase
{
	/** @var string GIF87a header */
	const GIF87A_HEADER = "\x47\x49\x46\x38\x37\x61";

	/** @var string GIF89a header */
	const GIF89A_HEADER = "\x47\x49\x46\x38\x39\x61";

	/** @var int GIF header size */
	const GIF_HEADER_SIZE = 6;

	protected $type = IMAGETYPE_GIF;

	public function __construct($filepath)
	{
		parent::__construct($filepath);

		//Initializing here for PHP < 5.6 backward compatibility
		$this->headerlength = self::GIF_HEADER_SIZE + self::SHORT_SIZE * 2;
	}

	public function extractSize()
	{
		// Get data needed for reading image dimensions as outlined by GIF87a
		// and GIF89a specifications

		return unpack('vwidth/vheight', $this->getHeaderPart(self::GIF_HEADER_SIZE, self::SHORT_SIZE * 2));
	}

	public function getSignature()
	{
		return $this->getHeaderPart(0, self::GIF_HEADER_SIZE);
	}

	public function isSignatureMatch()
	{
		return $this->getSignature() === self::GIF87A_HEADER || $this->getSignature() === self::GIF89A_HEADER;
	}
}
