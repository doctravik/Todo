<?php

namespace App\Models\Image;

class Image
{
    /**
     * Path to the image.
     * 
     * @var string
     */
    protected $path;

    /**
     * Image type consider as IMAGETYPE_XXX constant.
     * 
     * @var int
     */
    protected $type;

    /**
     * Image resource.
     * 
     * @var mixed
     */
    protected $resource;

    /**
     * Width of the image.
     * 
     * @var int
     */
    protected $width;

    /**
     * Height of the image.
     * 
     * @var int
     */
    protected $height;

    /**
     * Create a new instance of the Image.
     * 
     * @param string $path
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * Create Image instance from the given path
     * @param  string $path
     * @return Image
     */
    public static function createFromPath($path)
    {
        $image = new static($path);

        [ $image->width, $image->height, $image->type ] = getimagesize($path);

        $image->resource = imagecreatefromstring(file_get_contents($path));

        return $image;
    }

    /**
     * Get width of the image.
     * 
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Get height of the image.
     * 
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Get image resource.
     * 
     * @return mixed
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * Set image resource.
     * 
     * @param mixed $resource
     */
    public function setResource($resource)
    {
        $this->resource = $resource;
    }

    /**
     * Save image to file.
     *  
     * @return string filepath
     */
    public function save()
    {
        $uploadDirectory = config('image')['upload'];

        $name = $this->generateName();

        $targetFilePath = "{$uploadDirectory}/{$name}";

        return $this->putToFile($targetFilePath);
    }

    /**
     * Generate name of the file.
     * 
     * @return string
     */
    protected function generateName()
    {
        $name = sha1(
            time() . $this->getFilename()
        );
        $ext = $this->getExtension();

        return "{$name}.{$ext}";
    }

    /**
     * Get filename of the image.
     * 
     * @return string
     */
    protected function getFilename()
    {
        return pathinfo($this->name, PATHINFO_FILENAME);
    }

    /**
     * Get extension of the image.
     * 
     * @return string
     */
    protected function getExtension()
    {
        return pathinfo($this->name, PATHINFO_EXTENSION) 
                    ?: $this->getExtensionFromType()[$this->type];
    }

    /**
     * @return string
     */
    protected function getExtensionFromType()
    {
        return [
            IMAGETYPE_GIF => 'gif',
            IMAGETYPE_JPEG => 'jpeg',
            IMAGETYPE_PNG => 'png'
        ];
    }

    /**
     * Put image resource to file.
     *  
     * @param  string $targetFilePath
     * @return string $targetFilePath
     */
    protected function putToFile($targetFilePath)
    {
        switch ($this->type) {
            case IMAGETYPE_PNG:
                imagepng($this->resource, $targetFilePath, 100);
                break;

            case IMAGETYPE_JPEG:
                imagejpeg($this->resource, $targetFilePath, 100);
                break;

            case IMAGETYPE_GIF:
                imagegif($this->resource, $targetFilePath, 100);
                break;
        }

        return $targetFilePath;
    }
}