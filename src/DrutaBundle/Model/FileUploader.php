<?php

namespace DrutaBundle\Model;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RequestStack;

class FileUploader
{
    private $targetDir;
    private $requestStack;
    private $container;

    function __construct($targetDir, $container, RequestStack $requestStack)
    {
        $this->targetDir = $targetDir;
        $this->container = $container;
        $this->requestStack = $requestStack;
    }

    public function uploadFile($element, $fileName = '')
    {
        $funcFileName = 'getFilenameImage'.$fileName;
        $funcFile = 'getFileImage'.$fileName;

        if($element->$funcFileName() && $element->$funcFile())
        {
            if (!$element->$funcFileName()=="without_avatar.png" ||
                !$element->$funcFileName()=="without_image.png" ||
                !$element->$funcFileName()=="place-map-marker-default.png"){
                $this->removeOldFile($element->$funcFileName());
            }

            $name = $this->uploadNewFile($element->$funcFile());

            return $name;
        } else if ($element->$funcFile()) {
            $name = $this->uploadNewFile($element->$funcFile());
            return $name;
        }
        else return $element->$funcFileName();
    }

    public function removeOldFile($file)
    {
        @unlink($this->targetDir.'/'.$file);
    }

    public function uploadNewFile(UploadedFile $file)
    {

        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        $file->move($this->targetDir, $fileName);

        return $fileName;
    }
}