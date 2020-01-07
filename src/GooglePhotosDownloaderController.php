<?php

namespace Vigurdev\GooglePhotosDownloader;

use App\Http\Controllers\Controller;

class GooglePhotosDownloaderController extends Controller
{
    public function download()
    {
        $downloaderService = new GooglePhotosDownloaderService();

        $albumLink = 'https://photos.app.goo.gl/mBdCpcL9MRJxAPCH6';
        $downloaded = $downloaderService->processAlbum($albumLink);

        echo "Downloaded photos: {$downloaded}";
    }
}
