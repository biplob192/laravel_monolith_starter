<?php

if (!function_exists('uploadFile')) {
    function uploadFile($folderName, $file)
    {
        return $file->store($folderName, 'public');
    }
}
