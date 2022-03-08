<?php

namespace Sosat1101\Opensubtitles;

use Exception;

class OpenSubtitlesImp implements Subtitles
{

    public function login($username, $password)
    {
        $loginOpenSubtitles = new LoginOpenSubtitles($username, $password);
        $loginOpenSubtitles->initCurl();
        $loginOpenSubtitles->getResult();
        return $loginOpenSubtitles->getAccessToken();
    }

    public function search(string $name, string $language = "en"): array
    {
        $searchOpenSubtitles = new SearchOpenSubtitles(['query' => $name, 'languages' => $language]);
        $searchOpenSubtitles->initCurl();
        return $searchOpenSubtitles->getResult();
    }

    public function download(int $subtitleId, string $language = "en")
    {
        // access_token 需要从缓存中读取
        $access_token = "";
        $downloadOpenSubtitles = new DownloadOpenSubtitles($access_token, ['file_id' => $subtitleId]);
        $downloadOpenSubtitles->initCurl();
        $downloadOpenSubtitles->getResult();
        try {
            $downloadOpenSubtitles->execDownload();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return null;
    }
}