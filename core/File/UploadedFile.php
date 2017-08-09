<?php

namespace Core\File;

class UploadedFile
{
    /**
     * The temporary filename of the file in which the uploaded file was stored on the server.
     * 
     * @var string
     */
    protected $path;

    /**
     * The original name of the file on the client machine
     * 
     * @var string
     */
    protected $clientName;

    /**
     * The mime type of the file, if the browser provided this information. An example would be "image/gif". 
     * This mime type is however not checked on the PHP side and therefore don't take its value for granted
     * 
     * @var string
     */
    protected $mimeType;

    /**
     * The error code associated with this file upload.
     * 
     * @var int
     */
    protected $error;

    /**
     * The size, in bytes, of the uploaded file.
     * 
     * @var int
     */
    protected $size;

    /**
     * Create new instance of UploadedFile.
     * 
     * @param array $uploadedFile
     */
    public function __construct(array $uploadedFile)
    {
        $this->path = $uploadedFile['tmp_name'];
        $this->clientName = $uploadedFile['name'];
        $this->mimeType = $uploadedFile['type'];
        $this->error = $uploadedFile['error'];
        $this->size = $uploadedFile['size'];
    }

    /**
     * Get path to the UploadedFile.
     * 
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Get client original name of UploadedFile.
     * 
     * @return string
     */
    public function getClientName()
    {
        return $this->clientName;
    }

    /**
     * Get client mime type of UploadedFile.
     * 
     * @return string
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * Get error code associated with this file uploading.
     * 
     * @return int
     */
    public function getErrorCode()
    {
        return $this->error;
    }

    /**
     * Get size in byte of the UploadedFile.
     * 
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Move uploaded file to the new destination
     * 
     * @return boolean
     */
    public function move($destination)
    {
        if ($this->isValid()) {
            return move_uploaded_file($this->getPath(), $destination);
        }

        return false;
    }

    /**
     * Whether the file was uploaded without errors.
     * 
     * @return boolean
     */
    public function isValid()
    {
        return $this->error === UPLOAD_ERR_OK && is_uploaded_file($this->getPath());
    }
}