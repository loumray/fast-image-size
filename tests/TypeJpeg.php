<?php

/**
 * fast-image-size base test class
 * @package fast-image-size
 * @copyright (c) Marc Alexander <admin@m-a-styles.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FastImageSize\tests;

use PHPUnit\Framework\TestCase;

require_once dirname(__DIR__).DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php';

class TypeJpeg extends TestCase
{
	protected $path;
    
    public function setUp()
    {
        parent::setUp();

        $this->path = __DIR__.DIRECTORY_SEPARATOR.'fixture'.DIRECTORY_SEPARATOR;
	}
	
	public function dataJpegTest()
	{
		return array(
			array(false, "\xFF\xD8somemorerandomdata1"),
			array(false, "\xFF\xD8somedata\xFF\xE0\xFF\xFF\xFF\xFF"),
			array(array(
					'width'		=> 65535,
					'height'	=> 65535,
					'type'		=> IMAGETYPE_JPEG,
				),
				"\xFF\xD8somedata\xFF\xC0\xFF\xFF\xFF\xFF\xFF\xFF\xFF"
			),
		);
	}

	/**
	 * @dataProvider dataJpegTest
	 */
	public function testJpegLength($expected, $data)
	{
		$filepath = $this->path . 'test_file.jpg';
		@file_put_contents($filepath, $data);

		$actual = \FastImageSize\getimagesize($filepath);

		if ($expected !== false) {
			$expected = array_values($expected);
			//Dont compare more than the first 3 index
			unset($actual[3]);
			unset($actual['mime']);
		}
		
		@unlink($filepath);

		$this->assertEquals($expected, $actual);
	}
}
