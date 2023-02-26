<?php
namespace Addons\Image\Models;

class File extends \Fusion\Models\File {
    public function getThumbnailUrl($width, $height = null, $fit = null) {
        $url = $this->url;
        if (strpos($url, '/file') === 0) {
            $dimension = $width;
            if (isset($height)) $dimension .= 'x'.$height;

            $url = '/thumbnail'.substr($url, strlen('/file')).'/'.$dimension.(isset($fit) ? '_'.$fit : '');
        }
        return $url;
    }   
}