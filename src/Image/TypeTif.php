<?php

/**
 * fast-image-size image type tif
 * @package fast-image-size
 * @copyright (c) Marc Alexander <admin@m-a-styles.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FastImageSize\Image;

class TypeTif extends TypeBase
{
	/** @var int TIF header size. The header might be larger but the dimensions
	 *			should be in the first 512 bytes */
	const TIF_HEADER_SIZE = 512;

	/** @var int TIF tag for image height */
	const TIF_TAG_IMAGE_HEIGHT = 257;

	/** @var int TIF tag for image width */
	const TIF_TAG_IMAGE_WIDTH = 256;

	/** @var int TIF tag type for short */
	const TIF_TAG_TYPE_SHORT = 3;

	/** @var int TIF IFD entry size */
	const TIF_IFD_ENTRY_SIZE = 12;

	/** @var string TIF signature of intel type */
	const TIF_SIGNATURE_INTEL = 'II';

	/** @var string TIF signature of motorola type */
	const TIF_SIGNATURE_MOTOROLA = 'MM';

	/** @var array Size info array */
	protected $size;

	/** @var string Bit type of long field */
	protected $typeLong;

	/** @var string Bit type of short field */
	protected $typeShort;

	protected $type = IMAGETYPE_TIFF_MM;

	protected $headerlength = self::TIF_HEADER_SIZE;

	public function extractSize()
	{
		// Do not force length of header
		// $data = $this->getImage($filename, 0, self::TIF_HEADER_SIZE, false);

		$this->size = array();

		//Set byte type based on signature in header
		$this->setType();

		// Get offset of IFD
		list(, $offset) = unpack($this->typeLong, $this->getHeaderPart(self::LONG_SIZE, self::LONG_SIZE));

		// Get size of IFD
		list(, $sizeIfd) = unpack($this->typeShort, $this->getHeaderPart($offset, self::SHORT_SIZE));

		// Skip 2 bytes that define the IFD size
		$offset += self::SHORT_SIZE;

		// Filter through IFD
		for ($i = 0; $i < $sizeIfd; $i++) {
			// Get IFD tag
			$type = unpack($this->typeShort, $this->getHeaderPart($offset, self::SHORT_SIZE));

			// Get field type of tag
			$fieldType = unpack($this->typeShort . 'type', $this->getHeaderPart($offset + self::SHORT_SIZE, self::SHORT_SIZE));

			// Get IFD entry
			$ifdValue = $this->getHeaderPart($offset + 2 * self::LONG_SIZE, self::LONG_SIZE);

			// Set size of field
			$this->setSizeInfo($type[1], $fieldType['type'], $ifdValue);

			$offset += self::TIF_IFD_ENTRY_SIZE;
		}

		return $this->size;
	}

	public function getType()
	{
		$this->setType();
		
		return parent::getType();
	}

	public function setType()
	{
		//Set byte type based on signature in header
		$this->typeLong = 'N';
		$this->typeShort = 'n';
		$this->type = IMAGETYPE_TIFF_MM;

		if ($this->getSignature() === self::TIF_SIGNATURE_INTEL) {
			$this->typeLong = 'V';
			$this->typeShort = 'v';
			$this->type = IMAGETYPE_TIFF_II;
		}
	}

	public function getSignature()
	{
		return $this->getHeaderPart(0, self::SHORT_SIZE);
	}

	public function isSignatureMatch()
	{
		return in_array($this->getSignature(), array(self::TIF_SIGNATURE_INTEL, self::TIF_SIGNATURE_MOTOROLA));
	}
	
	/**
	 * Set size info
	 *
	 * @param int $dimensionType Type of dimension. Either width or height
	 * @param int $fieldLength Length of field. Either short or long
	 * @param string $ifdValue String value of IFD field
	 */
	protected function setSizeInfo($dimensionType, $fieldLength, $ifdValue)
	{
		// Set size of field
		$fieldSize = $fieldLength === self::TIF_TAG_TYPE_SHORT ? $this->typeShort : $this->typeLong;

		// Get actual dimensions from IFD
		if ($dimensionType === self::TIF_TAG_IMAGE_HEIGHT) {
			$this->size = array_merge($this->size, unpack($fieldSize . 'height', $ifdValue));
		} elseif ($dimensionType === self::TIF_TAG_IMAGE_WIDTH) {
			$this->size = array_merge($this->size, unpack($fieldSize . 'width', $ifdValue));
		}
	}
}
