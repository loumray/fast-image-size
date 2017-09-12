<?php

/**
 * fast-image-size base functions
 * @package fast-image-size
 * @copyright (c) Marc Alexander <admin@m-a-styles.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FastImageSize;

function getimagesize($path)
{
    $image = Image\Factory::create($path);

    if (is_null($image)) {
        return false;
    }

    return $image->getSize();    
}