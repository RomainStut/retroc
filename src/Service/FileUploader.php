<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{

	private $targetDirectory;

	public function __construct($directory){

		$this->targetDirectory = $directory;

	}

	public function upload(UploadedFile $file, $oldFileName = null)
	{
		$fileName = md5(uniqid()) . '.' . $file->guessExtension();

		$file->move($this->targetDirectory, $fileName);

		if($oldFileName and file_exists($this->targetDirectory . '/' . $oldFileName)){
			unlink($this->targetDirectory . '/' . $oldFileName);
		}

		return $fileName;
	}


}