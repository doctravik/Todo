<?php

namespace App\Models\Image;

use App\Models\Image\Image;

class ImageHandler
{
    /**
     * @var Image
     */
    protected $image;

    /**
     * Create an instance of the $image.
     * 
     * @param Image $image
     */
    public function __construct(Image $image)
    {
        $this->image = $image;    
    }

    /**
     * Resize image.
     * 
     * @param  integer $maxWidth
     * @param  integer $maxHeight
     * @return $this
     */
    public function resize($maxWidth = 320, $maxHeight = 240)
    {
        if ($this->image->getWidth() > $maxWidth || $this->image->getHeight() > $maxHeight) {
            $res = (new ResizeImage($this->image, $maxWidth, $maxHeight))->execute();
        }

        return $this;
    }

    /**
     * Save image.
     *
     * @return string $filepath
     */
    public function save()
    {
        return $this->image->save();
    }
}