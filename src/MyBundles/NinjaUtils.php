<?php

namespace App\MyBundles;

use App\MyBundles\Executer;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Exception;

class NinjaUtils
{
    private const NJ_CODE_START_V7_TO_V8 = 110; //line number where the custom code in versions 7 & 8 starts
    private const NJ_CODE_START_V4_TO_V6 = 83; //line number where the custom code in versions <= 6 starts
    private const MAX_FILE_SIZE = 134217728; // max file size to accept on the server
    public const NJ_ASSEMBLER_FILE = '../resources/ninja_editor/compilers/nja'; //path to the server nja files for the ninja editor
    public const NJ_COMPILER_FILE = '../resources/ninja_editor/compilers/njc'; // path to the server njc files for the ninja editor
    public const NINJA_FILE_PATH = '../resources/ninja_editor/nj_files/'; // path to the user nj fiels for the ninja editor
    public const ASM_FILE_PATH = '../resources/ninja_editor/asm_files/'; // path to the user asm fiels for the ninja editor
    public const BIN_FILE_PATH = '../resources/ninja_editor/bin_files/'; // path to the user bin fiels for the ninja editor
    public const TEST_FILES_PATH = '../resources/ninja_editor/TestFiles/'; // Path for the server test files.
    public const NINJA_EXTENSION = 'nj'; // The extensions for the nj files
    public const ASM_EXTENSION = 'asm'; // The extensions for the asm files
    public const BIN_EXTENSION = 'bin'; // The extensions for the bin files
    public const UPLOAD_DIR = '../resources/ksp_tester/uploads/'; // ksptester user uploads directory
    public const SERVER_TEST_FILES_DIR = '../resources/ksp_tester/bin_test_files/';
    ############################ref_uploads#############
    public const REF_FILE_PATH = '../resources/ksp_tester/references/refnjvm';
    public const REF_UPLOAD_DIR = '../resources/ksp_tester/ref_uploads/';

    public static int $version = 8;

    public const DEFAULT_ARGUMENTS = '1 2 3 4 5 6 7 8 9 10 11 12 13 14';


    /**
     * getNJAssemblerFile
     *
     * @param  int $version
     * @return string
     */
    public static function getNJAssemblerFile(int $version = 8)
    {
        return self::NJ_ASSEMBLER_FILE . $version;
    }

    /**
     * getNJCompilerFile
     *
     * @param  int $version
     * @return string
     */
    public static function getNJCompilerFile(int $version = 8)
    {
        return self::NJ_COMPILER_FILE . $version;
    }


    /**
     * assembles the asm code into a binary file.
     *
     * @param  string $asmFile the full path of the asmFile.
     * @param  string $binFile the full path of the binFile.
     * @param int $version the version to be used to assemble.
     * @return void
     */
    public static function assemble(string $asmFile, string $binFile, int $version = 8)
    {
        $commands = [
            self::getNJAssemblerFile($version),
            $asmFile,
            $binFile
        ];
        Executer::execute($commands);
    }

    /**
     * compiles a ninja file into an assembler file.
     *
     * @param  string $ninjaFile the full path of the ninjaFile.
     * @param  string $asmFile the full path of the asmFile.
     * @param int $version the version to be used to compile.
     * @return void
     */
    public static function compile(string $ninjaFile, string $asmFile, int $version)
    {
        // command to output file to asmFile
        $commands = [
            self::getNJCompilerFile($version),
            $ninjaFile,
            '--output',
            $asmFile
        ];
        Executer::execute($commands);
    }
    /**
     * returns content of a directory
     * @param string $dirFullPath
     */
    public static function getDirectoryContents(string $dirFullPath)
    {
        $command = [
            'ls',
            $dirFullPath
        ];
        return array_filter(explode("\n", Executer::execute($command)));
    }

    /**
     * runs a binary file using the path to the njvm file provided
     */
    public static function runBin(string $binFile, string $njvmFile, string $arguments, array $data)
    {
        if (
            $data === []
        ) {
            $command = sprintf("echo %s | %s %s %s", $arguments, self::getTimeOut(2 * 60), $njvmFile, $binFile);
        } else {
            $command = sprintf(
                "%s echo %s |%s %s %s %s",
                self::getULimitCmd($data['heapSize']),
                $arguments,
                self::getTimeOut(2 * 60),
                $njvmFile,
                $binFile,
                self::getGcCommand($data['stackSize'], $data['heapSize'], $data['gcstats'], $data['gcpurge'])
            );
        }
        // info if you want to get results ouput before timeout error, then make the getTimeOut time > executer timeout time
        //else the the output will come from symfony which doesn't include proccesed output
        return Executer::executeFromCommandLine($command, (2 * 60) + 4);
    }
    /**
     * Makes a file executable.
     * @param string $file the name of the file to make executable
     */
    public static function makeExecutable(string $file)
    {
        $command = "chmod 755 $file";
        return Executer::executeFromCommandLine($command, 5);
    }

    /**
     * Returns the contents of the Asmfile just as needed to display in the ninja editor.
     *
     * @param  string $file the location of the asm file to be read.
     * @return string the contents of the file needed to display in the ninja editor.
     * @throws Exception when the file is not available
     */
    public static function getAsmContents(string $file, int $version, int $shortenCode)
    {
        $writtencode = FileUtils::getContents($file);
        if ($shortenCode) {
            if ($version >= 7) {
                $writtencode = array_slice($writtencode, self::NJ_CODE_START_V7_TO_V8);
            } else {
                $writtencode = array_slice($writtencode, self::NJ_CODE_START_V4_TO_V6);
            }
        }
        $writtencode = implode("", $writtencode);
        return $writtencode;
    }
    /**
     * Attachs .nj to a file name
     * @param string $filename
     */
    public static function attachNinjaExtension(string $filename)
    {
        return $filename . '.' . self::NINJA_EXTENSION;
    }
    /**
     * Attachs .asm to a file name
     */
    public static function attachAsmExtension(string $filename)
    {
        return $filename . '.' . self::ASM_EXTENSION;
    }
    /**
     * Attachs .bin to a file name
     */
    public static function attachBinExtension(string $filename)
    {
        return $filename . '.' . self::BIN_EXTENSION;
    }
    /**
     * checks if the size of the uploaded file is lesser as the defined max_file_size
     */
    public static function isValidFileSize(UploadedFile $file)
    {
        $fileSize = $file->getSize();
        return $fileSize < self::MAX_FILE_SIZE;
    }
    /**
     * Moves a file to the upload directory and returns the full file path.
     */
    public static function moveFileToUploadDir(UploadedFile $file, string $filename)
    {
        return self::moveFileToDir($file, $filename, self::UPLOAD_DIR);
    }
    /**
     * Moves a file to the user njvm upload directory
     */
    public static function moveFileToUserNjvmDir(UploadedFile $file, string $filename)
    {
        return self::moveFileToDir($file, $filename, self::REF_UPLOAD_DIR);
    }
    /**
     * Moves a file to a given upload directory
     */
    public static function moveFileToDir(UploadedFile $file, string $filename, string $dirname)
    {
        $file->move($dirname, $filename);
        return sprintf('%s%s', $dirname, $filename);
    }
    /**
     *
     * @param UploadedFile $file
     * @param string $userIP
     * @return string a File name based on the extension and the ip address(md5 encoded) of the user.
     */
    public static function getIpBasedFileName(UploadedFile $file, string $userIP)
    {
        return sprintf('%s.%s', $userIP, self::getFileExtension($file));
    }
    /**
     * returns the file extenstion of an uploaded file
     * @param UploadedFile $file
     */
    public static function getFileExtension(UploadedFile $file)
    {
        return $file->getClientOriginalExtension() ?? '';
    }
    /**
     * Checks if an uploaded file has the right extension
     * @param UploadedFile $file
     */
    public static function isValidExtension(UploadedFile $file)
    {
        $extension = self::getFileExtension($file);
        switch ($extension) {
            case 'asm':
            case 'bin':
            case 'nj':
            case '':
                return $extension;
            default:
                return false;
        }
    }
    /**
     * Returns the asm fullpath name based on the ip (md5) encoded
     */
    public static function getAsmNameFromIP(string $ip)
    {
        return self::UPLOAD_DIR . $ip . '.asm';
    }

    /**
     * Returns the nj fullpath name based on the ip (md5) encoded
     */
    public static function getNinjaNameFromIP(string $ip)
    {
        return self::UPLOAD_DIR . $ip . '.nj';
    }
    /**
     * Returns the bin fullpath name based on the ip (md5) encoded
     */
    public static function getBinNameFromIP(string $ip)
    {
        return self::UPLOAD_DIR . $ip . '.bin';
    }
    /**
     * Returns the njvm fullpath name based on the ip (md5) encoded
     */
    public static function getRefNameFromIP(string $ip)
    {
        return self::REF_UPLOAD_DIR . $ip;
    }



    /**
     * getDataLimit
     *
     * @param  mixed $heapSize
     * @return int
     */
    public static function getDataLimit(int $heapSize)
    {
        if ($heapSize < 100) {
            $dataLimit = 2000;
        } elseif ($heapSize >= 100 && $heapSize <= 1000) {
            $dataLimit = 5000;
        } elseif ($heapSize >= 1000 && $heapSize <= 10000) {
            $dataLimit = intval($heapSize * 1.14);
        } elseif (($heapSize >= 10000) && ($heapSize <= 100000)) {
            $dataLimit = intval($heapSize * 1.04);
        } else {
            $dataLimit = intval($heapSize * 1.8);
        }
        return $dataLimit;
    }
    /**
     * gets a command which limits the amount of heap
     * @param int $heapSize the size of the heap
     */
    public static function getULimitCmd(int $heapSize)
    {
        $dataLimit = self::getDataLimit($heapSize);
        return "ulimit -SHd $dataLimit && " . self::getTimeOut(3 * 60);
    }
    /**
     * @param int $seconds the seconds for a timeout
     */
    public static function getTimeOut(int $seconds)
    {
        return "timeout -s 9 -k $seconds $seconds";
    }
    /**
     * returns a command which is needed for the garbage collection
     * @param int $stackSize the size of the stack
     * @param int $heapSize the size of the heap
     * @param bool $gcstats use the gcstats option
     * @param bool $gcpurge use the gcpurge option
     */
    public static function getGcCommand(int $stackSize, int $heapSize, bool $gcstats, bool $gcpurge)
    {
        return sprintf(
            "2>&1 --stack %d --heap %d %s %s",
            $stackSize,
            $heapSize,
            $gcstats ? '--gcstats' : '',
            $gcpurge ? '--gcpurge' : ''
        );
    }
    /**
     * Helps to get the ninja ref file path
     * @param int $version the version of the ninja ref file.
     * @return string the full file path to the ninja ref file
     */
    public static function getNinjaRefFile(int $version)
    {
        return self::REF_FILE_PATH . $version;
    }
    /**
     * encodes the ip address and returns a 32 character string.
     * The encoded string is the same if the ip address is encoded multiple times.
     * @param string $ip contains the ip address
     * @return string the 32 character string
     */
    public static function generateFileNameFromIp(string $ip)
    {
        return md5($ip);
    }
    /**
     * Generates random bytes and encode using md5
     * @param string $extension
     * @return string the last 8 characters of the md5 encoded string
     */
    public static function generateRandomFileName(string $extension = '.txt')
    {
        return substr(md5(random_bytes(10)), 25) . $extension;
    }
}