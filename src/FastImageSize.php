<?php
/**
 * fast-image-size base class
 * @package fast-image-size
 * @copyright (c) Marc Alexander <admin@m-a-styles.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace FastImageSize;


class FastImageSize
{
    public function getImageSize($file, $type = '')
    {
        $size = getimagesize($file);

        if (empty($size)) {
            return false;
        }

        return array(
            'width' => $size[0],
            'height' => $size[1],
            'type' => $size[2],
        );
    }
}
