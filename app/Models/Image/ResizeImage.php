<?php

namespace App\Models\Image;

use App\Models\Image\Image;

class ResizeImage
{
    /**
     * @var Image
     */
    protected $image;

    /**
     * @var int
     */
    protected $maxWidth;

    /**
     * @var int
     */
    protected $maxHeight;

    /**
     * Create new instance of ResizeImage.
     * 
     * @param Image $image
     * @param int $maxWidth
     * @param int $maxHeight
     */
    public function __construct(Image $image, $maxWidth, $maxHeight)
    {
        $this->image = $image;
        $this->maxWidth = $maxWidth;
        $this->maxHeight = $maxHeight;
    }

    /**
     * Process resizing.
     * 
     * @return boolean
     */
    public function execute()
    {
        [$newWidth, $newHeight] = $this->defineNewSizes();

        $newImageResource = imagecreatetruecolor($newWidth, $newHeight);

        $result = $this->copyImageWithNewSizes($newImageResource, $newWidth, $newHeight);

        $this->image->setResource($newImageResource);
        
        return $result;
    }

    /**
     * Define new sizes consider aspect ratio of the current image.
     * 
     * @return array
     */
    protected function defineNewSizes()
    {
        $ratio = min([
            $this->maxWidth / $this->image->getWidth(), 
            $this->maxHeight / $this->image->getHeight()
        ]);

        return [
            $this->image->getWidth() * $ratio, 
            $this->image->getHeight() * $ratio
        ];
    }

    /**
     * Copy current image resource to the blank image object with new sizes.
     * 
     * @param  mixed $newImageResource
     * @param  int $newWidth
     * @param  int $newHeight
     * @return boolean           
     */
    protected function copyImageWithNewSizes($newImageResource, $newWidth, $newHeight)
    {
        return imagecopyresampled(
            $newImageResource, 
            $this->image->getResource(), 
            0, 0, 0, 0, 
            $newWidth, $newHeight, 
            $this->image->getWidth(), $this->image->getHeight()
        );
    }
}