<?php
// src/Service/FileUploader.php
namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

readonly class FileHandler {

    public function __construct(
        private string           $uploadPath,
        private SluggerInterface $slugger) {
    }

    /**
     * @param UploadedFile $file
     * @param string|null $subfolder
     * @return string
     */
    public function upload(UploadedFile $file, string $subfolder = null): string {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();

        try {
            $file->move($this->getUploadPath() . '/' . $subfolder, $fileName);
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }

        return $fileName;
    }

    /**
     * Delete a file from the system
     * @param string $filepath
     * @return void
     */
    public function deleteIcon(string $filepath): void {
        $filesystem = new Filesystem();
        $realPath = $this->getIconPath() . '/' . $filepath;
        if ($filesystem->exists($realPath)) {
            $filesystem->remove($realPath);
        }
    }

    /**
     * @param string $filepath
     * @return void
     */
    public function deleteImage(string $filepath): void {
        $filesystem = new Filesystem();
        $realPath = $this->getImagePath() . '/' . $filepath;
        if ($filesystem->exists($realPath)) {
            $filesystem->remove($realPath);
        }
    }

    public function getUploadPath(): string {
        return $this->uploadPath;
    }

    public function getImagePath(): string {
        return $this->getUploadPath() . '/images';
    }

    public function getIconPath(): string {
        return $this->getUploadPath() . '/images/icons';
    }
}
