<?php

namespace App\MyBundles;

use Exception;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Process\Process;

class KspTester
{
    private string $extension;
    private int $version;
    private string $testBinFileLocation;
    private string $ip;
    private string $arguments;
    private array $gcData;
    private string $userNjvmFileLocation;
    private string $refNjvmFileLocation;

    public function __construct(int $version, string $ip)
    {
        $this->version = $version;
        $this->ip = $ip;
        $this->gcData = [];
        $this->arguments = '1 2 3 4 5 6 7 8 9'; // set default arguments.
        $this->refNjvmFileLocation = NinjaUtils::REF_FILE_PATH . $version;
    }

    public function withUserTestFile(UploadedFile $testFile)
    {
        $this->validateTestFile($testFile);
        // create te name of the testFile based on the ip address.
        $filename = NinjaUtils::getIpBasedFileName($testFile, $this->ip);
        // move the testFile to the new location
        NinjaUtils::moveFileToUploadDir($testFile, $filename);
        $this->testBinFileLocation = NinjaUtils::getBinNameFromIP($this->ip);
        return $this;
    }
    public function withServerTestFile(UploadedFile $testFile)
    {
        $this->validateTestFile($testFile);
        $this->testBinFileLocation = $testFile->getRealPath();
        return $this;
    }

    public function withUserNjvmFile(UploadedFile $njvmFile)
    {
        $this->validateNjvmFile($njvmFile);
        $this->userNjvmFileLocation = NinjaUtils::moveFileToUserNjvmDir($njvmFile, $this->ip . '.njvm');
        return $this;
    }



    public function withArguments(string $arguments)
    {
        $this->arguments = $arguments;
        return $this;
    }

    public function withGarbageCollectionData(array $gcData)
    {
        if($this->version !== 8) {
            throw new Exception("Garbage collection only available with version 8");
        }
        $this->gcData = $gcData;
        return $this;
    }
    public function test()
    {
        $refVmOutput = ''; // container for reference Output
        $userVmOutput = ''; // container for ownImplementationOutput

        switch ($this->extension) {
            // intentional fall through
            case 'nj':
                NinjaUtils::compile(NinjaUtils::getNinjaNameFromIP($this->ip), NinjaUtils::getAsmNameFromIP($this->ip), $this->version);
            case 'asm':
                NinjaUtils::assemble(NinjaUtils::getAsmNameFromIP($this->ip), NinjaUtils::getBinNameFromIP($this->ip), $this->version);
            case 'bin':
                NinjaUtils::makeExecutable($this->testBinFileLocation);
                // run with server reference
                // try and catch all errors and set errors as output.
                try {
                    $refVmOutput = NinjaUtils::runBin($this->testBinFileLocation, $this->refNjvmFileLocation, $this->arguments, $this->gcData);
                } catch (Exception $e) {
                    $refVmOutput = $e->getMessage();
                }
                // run with user implementtion
                NinjaUtils::makeExecutable($this->userNjvmFileLocation);
                try {
                    $userVmOutput = NinjaUtils::runBin($this->testBinFileLocation, $this->userNjvmFileLocation, $this->arguments, $this->gcData);
                } catch (Exception $e) {
                    $userVmOutput = $e->getMessage();
                }
            default:
        }

        $similar = strcmp($userVmOutput, $refVmOutput) === 0;
        return ['implementOutput' => $userVmOutput, 'referenceOutput' => $refVmOutput, 'similar' => $similar];
    }

    public function getFileNameByVersion()
    {
        $fileStr = Executer::executeFromCommandLine(
            'ls "$MY_VAR" | grep "$MY_VAR2" "$MY_VAR3"',
            10,
            [
                'MY_VAR' => '../resources/ksp_tester/bin_test_files',
                'MY_VAR2' => "-iE",
                'MY_VAR3' => "^v$this->version.*"
            ]
        );
        return array_filter(explode("\n", $fileStr));
    }
    private function validateNjvmFile(UploadedFile $njvmFile)
    {
        if (NinjaUtils::isValidFileSize($njvmFile) === false) {
            throw new Exception('File too large');
        }
    }
    private function validateTestFile(UploadedFile $testFile)
    {
        if (($this->extension = NinjaUtils::isValidExtension($testFile)) === false) {
            throw new Exception("Invalid extention  $testFile");
        }
        // check size of testfile. 
        if (NinjaUtils::isValidFileSize($testFile) === false) {
            throw new Exception('File too large');
        }
    }
}