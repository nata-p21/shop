<?php

namespace ShopBundle\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private $targetDirFull;
    private $targetDir;

    public function __construct($targetDirFull, $targetDir)
    {
        $this->targetDirFull = $targetDirFull;
        $this->targetDir = $targetDir;
    }

    public function upload(UploadedFile $file)
    {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        $file->move($this->getTargetDirFull(), $fileName);

        return $this->getTargetDir()."/".$fileName;
    }

    public function getTargetDirFull()
    {
        return $this->targetDirFull;
    }
    public function getTargetDir()
    {
        return $this->targetDir;
    }
}