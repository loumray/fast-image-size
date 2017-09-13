<?php

/**
 * fast-image-size image type iff
 * @package fast-image-size
 * @copyright (c) Marc Alexander <admin@m-a-styles.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FastImageSize\Image;

class TypeIff extends TypeBase
{
	/** @var int IFF header size. Grab more than what should be needed to make
	 * sure we have the necessary data */
	const IFF_HEADER_SIZE = 32;

	/** @var string IFF header for Amiga type */
	const IFF_HEADER_AMIGA = 'FORM';

	/** @var string IFF header for Maya type */
	const IFF_HEADER_MAYA = 'FOR4';

	/** @var string IFF BTMHD for Amiga type */
	const IFF_AMIGA_BTMHD = 'BMHD';

	/** @var string IFF BTMHD for Maya type */
	const IFF_MAYA_BTMHD = 'BHD';

	/** @var string PHP pack format for unsigned short */
	const PACK_UNSIGNED_SHORT = 'n';

	/** @var string PHP pack format for unsigned long */
	const PACK_UNSIGNED_LONG = 'N';

	/** @var string BTMHD of current image */
	protected $btmhd;

	/** @var int Size of current BTMHD */
	protected $btmhdSize;

	/** @var string Current byte type */
	protected $byteType;

	protected $type = IMAGETYPE_IFF;
	
	protected $headerlength = self::IFF_HEADER_SIZE;

	public function extractSize()
	{
		// Set type constraints
		// Maya version
		$this->btmhd 		= self::IFF_MAYA_BTMHD;
		$this->btmhdSize 	= self::LONG_SIZE * 2;
		$this->byteType 	= self::PACK_UNSIGNED_LONG;

		// Amiga version of IFF
		if ($this->getSignature() === 'FORM') {
			$this->btmhd 		= self::IFF_AMIGA_BTMHD;
			$this->btmhdSize 	= self::LONG_SIZE;
			$this->byteType		= self::PACK_UNSIGNED_SHORT;
		}

		// Get size from data
		$btmhdPosition = strpos($this->getHeaderPart(), $this->btmhd);
		return unpack("{$this->byteType}width/{$this->byteType}height", $this->getHeaderPart($btmhdPosition + self::LONG_SIZE + strlen($this->btmhd), $this->btmhdSize));
	}

	/**
	 * Get IFF signature from data string
	 */
	 public function getSignature()
	{
		return $this->getHeaderPart(0, self::LONG_SIZE);
	}

	public function isSignatureMatch()
	{
		$signature = $this->getSignature();

		// Check if image is IFF
		if ($signature !== self::IFF_HEADER_AMIGA &&
			$signature !== self::IFF_HEADER_MAYA
		) {
			return false;
		}

		return true;
	}
}
