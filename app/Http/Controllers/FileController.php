<?php

namespace App\Http\Controllers;

use App\Interfaces\PublicFileRepositoryInterface;

class FileController extends Controller {
    private PublicFileRepositoryInterface $fileRepository;

    public function __construct(PublicFileRepositoryInterface $fileRepository)
    {
        $this->fileRepository = $fileRepository;
    }

    public function loadFile($fileName): ?string
    {
        return $this->fileRepository->loadFile($fileName);
    }
}
