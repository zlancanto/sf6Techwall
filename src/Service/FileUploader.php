<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

readonly class FileUploader
{
    /*
     * Au niveau des Services, l'injection de dépendance
     * se fait UNIQUEMENT dans le constructeur
     * Ref : Youtube chaine 'Tech Wall' playlist sur symfony vidéos 51&52
     * */

    public function __construct(
        private string $targetDirectory,
        private SluggerInterface $slugger,
    ) {}

    public function upload(UploadedFile $file): string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

        try {
            $file->move($this->getTargetDirectory(), $fileName);
        } catch (FileException $e) {
            dd($e->getMessage());
            // ... handle exception if something happens during file upload
        }

        return $fileName;
    }

    private function getTargetDirectory(): string
    {
        return $this->targetDirectory;
    }
}