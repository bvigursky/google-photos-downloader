<?php

namespace Vigurdev\GooglePhotosDownloader;

use Illuminate\Support\Facades\Log;

class GooglePhotosDownloaderService
{
    /**
     * @param $link
     * @return bool|int
     */
    public function processAlbum($link)
    {
        $context = [
            'link' => $link,
        ];

        if ($html = file_get_contents($link)) {
            if (preg_match_all('/"(https:\/\/lh3\.googleusercontent\.com\/[a-zA-Z0-9\-_]*)"/', $html, $photos)) {
                $photosList = array_unique($photos[1]);
                $downloaded = 0;
                foreach ($photosList as $photoLink) {
                    if ($this->downloadPhoto($photoLink)) {
                        $downloaded++;
                    }
                }

                return $downloaded;
            } else {
                Log::error('Could not find photos', $context);
            }
        } else {
            Log::error('Could not get album content', $context);
        }

        return false;
    }

    /**
     * @param $link
     * @return bool
     */
    protected function downloadPhoto($link, $thumbnail = false)
    {
        if (!$thumbnail) {
            $link .= '=d';
        }
        $headers = get_headers($link, 1);
        if (
            !empty($headers['Content-Disposition'])
            && ($filename = $this->getFileNameFromDescription($headers['Content-Disposition']))
        ) {
            if (file_put_contents(__DIR__ . '/images/' . $filename, file_get_contents($link))) {
                return true;
            } else {
                Log::error('Could not store file', $headers);
            }
        } else {
            Log::info('Could not process file name', $headers);
        }

        return false;
    }

    /**
     * @param $description
     * @return bool|string
     */
    protected function getFileNameFromDescription($description)
    {
        if (preg_match('/filename[^;=\n]*=(([\'"]).*?\2|[^;\n]*)/', $description, $filename)) {
            return trim($filename[1], '\'"');
        }

        return false;
    }
}


