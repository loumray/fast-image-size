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

class RemoteTest extends TestCase
{
	protected $path;
    
    public function setUp()
    {
        parent::setUp();

        $this->path = __DIR__.DIRECTORY_SEPARATOR.'fixture'.DIRECTORY_SEPARATOR;
	}
	
	public function dataGetImageSizeRemote()
	{
		return array(
			array(
				'https://secure.gravatar.com/avatar/55502f40dc8b7c769880b10874abc9d0.jpg'
			),
			array(
				'http://www.techspot.com/articles-info/1121/images/P34WS-12.jpg',
			),
		);
	}

	/**
	 * @dataProvider dataGetImageSizeRemote
	 */
	public function testGetImageSize_remote($url)
	{
		$actual = \FastImageSize\getimagesize($url);
		
		//Try to match PHP getimagesize behavior
		$expected = @\getimagesize($url);
		unset($expected['bits']);
		unset($expected['channels']);

		$this->assertSame($expected, $actual);
	}

	/**
	 * @dataProvider dataGetImageSizeRemote
	 */
	public function testOldGetImageSize_remote($url)
	{
		$FastImageSize = new \FastImageSize\FastImageSize();
		
		$actual = $FastImageSize->getImageSize($url);
 
		if (!empty($actual)) {
			$actual = array_values($actual);
		}
		
		//Try to match PHP getimagesize behavior
		$expected = @\getimagesize($url);
		unset($expected[3]);
		unset($expected['mime']);
		unset($expected['bits']);
		unset($expected['channels']);

		$this->assertSame($expected, $actual);
	}
}
