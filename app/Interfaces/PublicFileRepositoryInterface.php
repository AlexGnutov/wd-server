<?php

namespace App\Interfaces;

interface PublicFileRepositoryInterface {
    public function saveFile($file): string;
    public function loadFile($fileName);
}
