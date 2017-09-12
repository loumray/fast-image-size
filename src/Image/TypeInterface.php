<?php

/**
 * fast-image-size image type interface
 * @package fast-image-size
 * @copyright (c) Marc Alexander <admin@m-a-styles.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FastImageSize\Image;

interface TypeInterface
{
	/** @var int 4-byte long size */
	const LONG_SIZE = 4;

	/** @var int 2-byte short size */
	const SHORT_SIZE = 2;

	/**
	 * Get size of supplied image
	 *
	 * @return array or false on failure
	 */
	public function getSize();

	/**
	 * Extract size out of minimal image data
	 *
	 * @return array or false on failure
	 */
	public function extractSize();

	/**
	 * Get signature image
	 *
	 * @return string or false on failure
	 */
	public function getSignature();

	/**
	 * Check if signature match image type
	 *
	 * @return bool true if signature match false otherwise
	 */
	public function isSignatureMatch();
}
