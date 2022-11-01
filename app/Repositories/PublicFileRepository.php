<?php

namespace App\Repositories;

use App\Interfaces\PublicFileRepositoryInterface;
use Illuminate\Support\Facades\Storage;

class PublicFileRepository implements PublicFileRepositoryInterface
{

    public function saveFile($file): string
    {
        $path = Storage::putFile('public/images', $file);
        $arr = explode('/', $path);
        return array_pop($arr);
    }

    public function loadFile($fileName): ?string
    {
        return Storage::disk('public')->get('images/' . $fileName);
    }
}
