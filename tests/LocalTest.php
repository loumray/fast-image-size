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

class FastImageSize extends TestCase
{
	protected $path;
    
    public function setUp()
    {
        parent::setUp();

        $this->path = __DIR__.DIRECTORY_SEPARATOR.'fixture'.DIRECTORY_SEPARATOR;
	}
	
	public function dataGetImageSize()
	{
		return array(
			array('foobar', 'image/bmp', false),
			array('png', 'image/png', array('width' => 1, 'height' => 1, 'type' => IMAGETYPE_PNG)),
			array('gif', 'image/png', false),
			array('png', '', array('width' => 1, 'height' => 1, 'type' => IMAGETYPE_PNG)),
			array('gif', 'image/gif', array('width' => 1, 'height' => 1, 'type' => IMAGETYPE_GIF)),
			array('jpg', 'image/gif', false),
			array('gif', '', array('width' => 1, 'height' => 1, 'type' => IMAGETYPE_GIF)),
			array('jpg', 'image/jpg', array('width' => 1, 'height' => 1, 'type' => IMAGETYPE_JPEG)),
			array('jpg', 'image/jpeg', array('width' => 1, 'height' => 1, 'type' => IMAGETYPE_JPEG)),
			array('png', 'image/jpg', false),
			array('jpg', '', array('width' => 1, 'height' => 1, 'type' => IMAGETYPE_JPEG)),
			array('psd', 'image/psd', array('width' => 2, 'height' => 1, 'type' => IMAGETYPE_PSD)),
			array('psd', 'image/photoshop', array('width' => 2, 'height' => 1, 'type' => IMAGETYPE_PSD)),
			array('jpg', 'image/psd', false),
			array('psd', '', array('width' => 2, 'height' => 1, 'type' => IMAGETYPE_PSD)),
			array('bmp', 'image/bmp', array('width' => 2, 'height' => 1, 'type' => IMAGETYPE_BMP)),
			array('png', 'image/bmp', false),
			array('bmp', '', array('width' => 2, 'height' => 1, 'type' => IMAGETYPE_BMP)),
			array('tif', 'image/tif', array('width' => 1, 'height' => 1, 'type' => IMAGETYPE_TIFF_II)),
			array('png', 'image/tif', false),
			array('tif', '', array('width' => 1, 'height' => 1, 'type' => IMAGETYPE_TIFF_II)),
			array('tif_compressed', 'image/tif', array('width' => 2, 'height' => 1, 'type' => IMAGETYPE_TIFF_II)),
			array('png', 'image/tiff', false),
			array('tif_compressed', '', array('width' => 2, 'height' => 1, 'type' => IMAGETYPE_TIFF_II)),
			array('tif_msb', 'image/tif', array('width' => 2, 'height' => 1, 'type' => IMAGETYPE_TIFF_MM)),
			array('tif_msb', '', array('width' => 2, 'height' => 1, 'type' => IMAGETYPE_TIFF_MM)),
			array('wbmp', 'image/wbmp', array('width' => 2, 'height' => 1, 'type' => IMAGETYPE_WBMP)),
			array('foobar', 'image/wbmp', false),
			array('wbmp', 'image/vnd.wap.wbmp', array('width' => 2, 'height' => 1, 'type' => IMAGETYPE_WBMP)),
			array('png', 'image/vnd.wap.wbmp', false),
			array('wbmp', '', array('width' => 2, 'height' => 1, 'type' => IMAGETYPE_WBMP)),
			array('iff', 'image/iff', array('width' => 2, 'height' => 1, 'type' => IMAGETYPE_IFF)),
			array('iff', 'image/x-iff', array('width' => 2, 'height' => 1, 'type' => IMAGETYPE_IFF)),
			array('iff_maya', 'iamge/iff', array('width' => 2, 'height' => 1, 'type' => IMAGETYPE_IFF)),
			array('png', 'image/iff', false),
			array('png', 'image/x-iff', false),
			array('iff', '', array('width' => 2, 'height' => 1, 'type' => IMAGETYPE_IFF)),
			array('iff_maya', '', array('width' => 2, 'height' => 1, 'type' => IMAGETYPE_IFF)),
			array('foobar', 'image/iff', false),
			array('jp2', 'image/jp2', array('width' => 2, 'height' => 1, 'type' => IMAGETYPE_JPEG2000)),
			array('jp2', 'image/jpx', array('width' => 2, 'height' => 1, 'type' => IMAGETYPE_JPEG2000)),
			array('jp2', 'image/jpm', array('width' => 2, 'height' => 1, 'type' => IMAGETYPE_JPEG2000)),
			array('jpg', 'image/jp2', false),
			array('jpx', 'image/jpx', array('width' => 2, 'height' => 1, 'type' => IMAGETYPE_JPEG2000)),
			array('jp2', '', array('width' => 2, 'height' => 1, 'type' => IMAGETYPE_JPEG2000)),
			array('jpx', '', array('width' => 2, 'height' => 1, 'type' => IMAGETYPE_JPEG2000)),
			array('ico', 'image/x-icon', array('width' => 2, 'height' => 1, 'type' => IMAGETYPE_ICO)),
			array('ico', 'image/icon', array('width' => 2, 'height' => 1, 'type' => IMAGETYPE_ICO)),
			array('ico', 'image/ico', array('width' => 2, 'height' => 1, 'type' => IMAGETYPE_ICO)),
			array('ico', 'image/vnd.microsoft.icon', array('width' => 2, 'height' => 1, 'type' => IMAGETYPE_ICO)),
			array('ico', '', array('width' => 2, 'height' => 1, 'type' => IMAGETYPE_ICO)),
			array('foobar', 'image/x-icon', false),
			array('png', 'image/icon', false),
			array('meh', '', false),
			array('meh', 'image/meh', false),
			array('exif.jpg', 'image/jpeg', array('width' => 100, 'height' => 100, 'type' => IMAGETYPE_JPEG)),
			array('phpBB_logo.jpg', '', array('width' => 152, 'height' => 53, 'type' => IMAGETYPE_JPEG)),
			array('phpBB_logo.jpg', 'image/jpg', array('width' => 152, 'height' => 53, 'type' => IMAGETYPE_JPEG)),
			array('dog.jpg', '', array('width' => 300, 'height' => 300, 'type' => IMAGETYPE_JPEG)),
			// Capital file names
			array('JPGL', 'image/jpg', array('width' => 1, 'height' => 1, 'type' => IMAGETYPE_JPEG)),
			array('JPGL', '', array('width' => 1, 'height' => 1, 'type' => IMAGETYPE_JPEG)),
			array('PNGL', 'image/png', array('width' => 1, 'height' => 1, 'type' => IMAGETYPE_PNG)),
			array('PNGL', '', array('width' => 1, 'height' => 1, 'type' => IMAGETYPE_PNG)),
			array('JPGL', 'image/png', false),
			// Capital extesion
			array('jpg.JPG', 'image/jpg', array('width' => 1, 'height' => 1, 'type' => IMAGETYPE_JPEG)),
			array('jpg.JPG', '', array('width' => 1, 'height' => 1, 'type' => IMAGETYPE_JPEG)),
			array('png.PNG', 'image/png', array('width' => 1, 'height' => 1, 'type' => IMAGETYPE_PNG)),
			array('png.PNG', '', array('width' => 1, 'height' => 1, 'type' => IMAGETYPE_PNG)),
			array('jpg.JPG', 'image/png', array('width' => 1, 'height' => 1, 'type' => IMAGETYPE_JPEG)), // extension override incorrect mime type
		);
	}

	/**
	 * @dataProvider dataGetImageSize
	 */
	public function testGetImageSize($file, $mime_type, $shouldbe)
	{

		$actual = \FastImageSize\getimagesize($this->path.$file);

		//Expect to match PHP getimagesize behavior
		$expected = @\getimagesize($this->path.$file);
		unset($expected['bits']);
		unset($expected['channels']);

		//Sometime PHP getimagesize might failed while current getimagesize extract size than compare with expected size listed
		//Like for iff_maya
		if ($expected === false && $shouldbe !== false) {
			$expected = array_values($shouldbe);
			//Dont compare more than the first 3 index
			unset($actual[3]);
			unset($actual['mime']);
		}

		$this->assertSame($expected, $actual);
	}
}
