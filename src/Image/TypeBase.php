<?php

/**
 * fast-image-size image type base
 * @package fast-image-size
 * @copyright (c) Marc Alexander <admin@m-a-styles.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FastImageSize\Image;

abstract class TypeBase implements TypeInterface
{
	protected $type;
	protected $filepath;

	protected $header;
	protected $headerlength = 0;

	public function __construct($filepath)
	{
		$this->filepath = $filepath;
	}

	public function getType()
	{
		return $this->type;
	}

	public function getHeaderPart($start = 0, $length = null)
	{
		//if header never fetched or requested length is bigger then current header refetch header
		if (is_null($this->header) || $length > strlen($this->header)) {
			$this->fetch();
		}

		if (is_null($length)) {
			$length = $this->getHeaderLength();
		}

		return substr($this->header, $start, $length);
	}

	public function getHeaderLength()
	{
		return $this->headerlength;
	}

	public function setHeader($header)
	{
		$this->header = $header;

		return $this;
	}

	public function fetch()
	{
		$this->setHeader($this->getData(0, $this->getHeaderLength()));

		return $this->header;
	}

	public function isTypeMatch()
	{
		$header = $this->getHeaderPart();
		if (empty($header)) {
			return false;
		}

		$signature = $this->getSignature();
		//If current header size is smaller than signature
		if (empty($signature) || strlen($header) < strlen($signature)) {
			return false;
		}

		if (!$this->isSignatureMatch()) {
			return false;
		}

		return true;
	}

	public function getSize()
	{
		if (!$this->isTypeMatch()) {
			return false;
		}

		$size = $this->extractSize();

		if (empty($size)) {
			return false;
		}
		
		return array(
			$size['width'],
			$size['height'],
			$this->getType(),
			'width="'.$size['width'].'" height="'.$size['height'].'"',
			'mime' => image_type_to_mime_type($this->getType()),
		);
	}

	/**
	 * Get image from specified path/source
	 *
	 * @param int $start Offset position at which reading of the image should start
	 * @param int $length Maximum length that should be read
	 *
	 * @return false|string Image data or false if result was empty
	 */
	protected function getData($start, $length)
	{
		$opts = array(
			'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
			),
		);

		//Add referer if scheme is http or https
		$parsedFilename = parse_url($this->filepath);
		if (isset($parsedFilename['scheme']) &&
			($parsedFilename['scheme'] == 'http' || $parsedFilename['scheme'] == 'https')) {

			$referer = $parsedFilename['scheme'].'://'.$parsedFilename['host'];

			$opts['http'] = array(
				'header' => array(
					"Referer: $referer\r\n"
				)
			);
		}
		
		$data = @file_get_contents($this->filepath, null, stream_context_create($opts), $start, $length);

		return empty($data) ? false : $data;
	}
}
