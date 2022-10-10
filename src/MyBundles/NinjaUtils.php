<?php

namespace App\MyBundles;

use App\MyBundles\Executer;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class NinjaUtils
{
    private const NJ_CODE_START = 110;
    private const MAX_FILE_SIZE = 134217728;
    public const NJ_ASSEMBLER_FILE = '../resources/ninja_editor/compilers/nja';
    public const NJ_COMPILER_FILE = '../resources/ninja_editor/compilers/njc';
    public const NINJA_FILE_PATH = '../resources/ninja_editor/nj_files/';
    public const ASM_FILE_PATH = '../resources/ninja_editor/asm_files/';
    public const BIN_FILE_PATH = '../resources/ninja_editor/bin_files/';
    public const NINJA_EXTENSION = 'nj';
    public const ASM_EXTENSION = 'asm';
    public const BIN_EXTENSION = 'bin';
    public const UPLOAD_DIR = '../resources/ksp_tester/uploads/';
    #########################################
    public const REF_FILE_PATH = '../resources/ksp_tester/references/refnjvm';
    public const REF_UPLOAD_DIR = '../resources/ksp_tester/ref_uploads/';

    public static int $version = 8;


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
     * getRefImplementation
     *
     * @param  int $version
     * @return string
     */
    public static function getRefImplementation(int $version = 8)
    {
        return self::REF_FILE_PATH . $version;
    }

    /**
     * assembles the asm code into a binary file.
     *
     * @param  string $asmFile the full path of the asmFile.
     * @param  string $binFile the full path of the binFile.
     * @param int $version the version to be used to assemble.
     * @return void
     */
    public static  function assemble(string $asmFile, string $binFile, int $version = 8)
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
     * runBinary
     *
     * @param  string $referenceFile
     * @param string $testFile
     * @param  string $params
     * @return string
     */
    public static function runReferenceBin(string $file,  int $version, string $params, array $data)
    {
        $referenceBin = self::REF_FILE_PATH . $version;
        return self::runBin($file, $referenceBin, $params, $data);
    }


    public static function runBin(string $binFile, string $reference, string $params, array $data)
    {
        if (
            $data === []
        ) {
            $command  = sprintf("echo %s | %s %s", $params, $reference, $binFile);
        } else {
            $command = sprintf(
                "%s echo %s | %s %s %s",
                self::getULimit_Cmd($data['heapSize']),
                $params,
                $reference,
                $binFile,
                self::getGcCommand($data['stackSize'], $data['heapSize'], $data['gcstats'], $data['gcpurge'])
            );
        }
        echo "\n". $command . "\n";
        return Executer::executeFromCommandLine($command);
    }

    public static function makeExecutable(string $file)
    {
        $command =  "chmod 755 $file";
        return Executer::executeFromCommandLine($command);
    }

    /**
     * Returns the contents of the Asmfile just as needed to display in the ninja editor.
     *
     * @param  string $file the location of the asm file to be read.
     * @return string the contents of the file needed to display in the ninja editor.
     * @throws Exception when the file is not available
     */
    public static function getAsmContents(string $file)
    {
        $contents = FileUtils::getContents($file);
        $writtencode = array_slice($contents, self::NJ_CODE_START);
        $writtencode =  implode("", $writtencode);
        return $writtencode;
    }

    public static function attachNinjaExtension(string $filename)
    {
        return $filename . '.' . self::NINJA_EXTENSION;
    }

    public static function attachAsmExtension(string $filename)
    {
        return $filename . '.' . self::ASM_EXTENSION;
    }
    public static function attachBinExtension(string $filename)
    {
        return $filename . '.' . self::BIN_EXTENSION;
    }

    public static function isValidFileSize(UploadedFile $file)
    {
        $fileSize  = $file->getSize();
        return $fileSize < self::MAX_FILE_SIZE;
    }
    /**
     * Uploads a file to the upload directory and returns the full file path.
     */
    public static function moveFileToUploadDir(UploadedFile $file, string $filename)
    {
        return self::moveFileToDir($file, $filename, self::UPLOAD_DIR);
    }

    public static function moveFileToUserNjvmDir(UploadedFile $file, string $filename)
    {
        return self::moveFileToDir($file, $filename, self::REF_UPLOAD_DIR);
    }

    public static function moveFileToDir(UploadedFile $file, string $filename,  string $dirname)
    {
        $file->move($dirname, $filename);
        return sprintf('%s%s', $dirname, $filename);
    }
    /**
     * 
     * @param UploadedFile $file
     * @param string $userIP
     * @return string a File name based on the extension and the ip address of the user.
     */
    public static function getIpBasedFileName(UploadedFile $file, string $userIP)
    {
        return sprintf('%s.%s', $userIP, self::getFileExtension($file));
    }
    public static function getFileExtension(UploadedFile $file)
    {
        return $file->getClientOriginalExtension() ?? '';
    }

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

    public static function getAsmNameFromIP(string $ip)
    {
        return self::UPLOAD_DIR . $ip . '.asm';
    }

    public static function getNinjaNameFromIP(string $ip)
    {
        return self::UPLOAD_DIR . $ip . '.nj';
    }
    public static function getBinNameFromIP(string $ip)
    {
        return self::UPLOAD_DIR . $ip . '.bin';
    }
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
        } else if ($heapSize >= 1000 && $heapSize <= 10000) {
            $dataLimit = intval($heapSize * 1.14);
        } else if (($heapSize >= 10000) && ($heapSize <= 100000)) {
            $dataLimit = intval($heapSize * 1.04);
        } else {
            $dataLimit = intval($heapSize * 1.8);
        }
        return $dataLimit;
    }
    public static function getULimit_Cmd(int $heapSize)
    {
        $dataLimit = self::getDataLimit($heapSize);
        return "ulimit -SHd $dataLimit && timeout -k 9 20m";
    }

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

    public static function getBinGCRunCommand()
    {
        return "%s echo %s | %s %s %s";
        /*
         * getUlimit_cmd
         * params
         * ./njvm
         * .nj file
         * gc_command
         */
    }
}
