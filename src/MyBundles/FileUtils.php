<?php

namespace App\MyBundles;

use exception;

class FileUtils
{


    /**
     * Reads the content of any file and returns it as an array containing the lines.
     *
     * @param  string $file the full path of the file to be read.
     * @return array contains the content of the file.
     * @throws exception when the file is not available
     * */
    public static function getContents(string $file)
    {
        if ($content = file($file)) {
            return $content;
        }
        throw new exception('File is not available');
    }


    /**
     * Writes contents to a given file path.
     *
     * @param  string $content The content to write into the file.
     * @param  string $file the full path of the file.
     * @return boolean true when writing was successfull.
     * @throws Exception when writing was unsuccessfull.
     */
    public static function writeToFile(string $content, string $file)
    {
        if (!file_put_contents($file, $content)) {
            throw new exception('An error occured while writing to file');
        }
        return true;
    }
    
}
