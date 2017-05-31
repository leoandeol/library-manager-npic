<?php 

namespace AppBundle\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    public function __construct()
    {
    }

    public function upload(UploadedFile $file, $targetDir, $id)
    {
        $fileName =$id.'.'.$file->guessExtension();

        $file->move($targetDir, $fileName);

        return $fileName;
    }

    public function getTargetDir()
    {
        return $this->targetDir;
    }
}

?>