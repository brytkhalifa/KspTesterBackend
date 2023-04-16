<?php

namespace App\MyBundles;

use Exception;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Process\Process;

class KspTester
{
    private string $extension; // extension of the uploaded file
    private int $version; // version of the test case
    private string $testBinFileLocation; // the location of the binary file (can be user or server provided)
    private string $ip; // the md5 representation of the users ip address
    private string $arguments; // arguments for the tester
    private array $gcData; // garbage collection data.
    private string $userNjvmFileLocation; // the location of the uploaded user njvm
    private string $refNjvmFileLocation; // the location of the server reference njvm

    public function __construct(int $version, string $ip)
    {
        $this->version = $version;
        $this->ip = $ip;
        $this->gcData = [];
        $this->arguments = NinjaUtils::DEFAULT_ARGUMENTS; // set default arguments.
        $this->refNjvmFileLocation = NinjaUtils::REF_FILE_PATH . $version;
    }
    /**
     * Sets the user testfile as the testfile for the tester
     * @param UploadedFile $testFile the uploaded testfile
     */
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
    /**
     * Sets the server test file as the testfile for the tester
     * @param UploadedFile $testFile the server testfile
     */
    public function withServerTestFile(UploadedFile $testFile)
    {
        $this->validateTestFile($testFile);
        $this->testBinFileLocation = $testFile->getRealPath();
        return $this;
    }
    /**
     * Sets the uploaded user njvm file.
     * @param UploadedFile $njvmFile the server testfile
     */
    public function withUserNjvmFile(UploadedFile $njvmFile)
    {
        $this->validateNjvmFile($njvmFile);
        $this->userNjvmFileLocation = NinjaUtils::moveFileToUserNjvmDir($njvmFile, $this->ip . '.njvm');
        return $this;
    }


    /**
     * @param string $arguments set the arguments for the tester
     */
    public function withArguments(string $arguments)
    {
        $this->arguments = $arguments;
        return $this;
    }
    /**
     * If version is 8, adds garbage collection data to the tester
     * @param array $gcData
     */
    public function withGarbageCollectionData(array $gcData)
    {
        if ($this->version !== 8) {
            throw new Exception("Garbage collection only available with version 8");
        }
        $this->gcData = $gcData;
        return $this;
    }
    /**
     * Runs the ksp tester based on the information in the instance.
     */
    public function test()
    {
        $refVmOutput = ''; // container for reference Output
        $userVmOutput = ''; // container for ownImplementationOutput

        switch ($this->extension) {
            // intentional fall through
            case 'nj':
                NinjaUtils::compile(
                    NinjaUtils::getNinjaNameFromIP($this->ip),
                    NinjaUtils::getAsmNameFromIP($this->ip),
                    $this->version
                );
            case 'asm':
                NinjaUtils::assemble(
                    NinjaUtils::getAsmNameFromIP($this->ip),
                    NinjaUtils::getBinNameFromIP($this->ip),
                    $this->version
                );
            case 'bin':
                NinjaUtils::makeExecutable($this->testBinFileLocation);
                // run with server reference
                // try and catch all errors and set errors as output.
                try {
                    $refVmOutput = NinjaUtils::runBin(
                        $this->testBinFileLocation,
                        $this->refNjvmFileLocation,
                        $this->arguments,
                        $this->gcData
                    );
                } catch (Exception $e) {
                    $refVmOutput = $e->getMessage();
                }
                // run with user implementtion
                NinjaUtils::makeExecutable($this->userNjvmFileLocation);
                try {
                    $userVmOutput = NinjaUtils::runBin(
                        $this->testBinFileLocation,
                        $this->userNjvmFileLocation,
                        $this->arguments,
                        $this->gcData
                    );
                } catch (Exception $e) {
                    $userVmOutput = $e->getMessage();
                }
            default:
        }

        $similar = strcmp($userVmOutput, $refVmOutput) === 0;
        return ['implementOutput' => $userVmOutput, 'referenceOutput' => $refVmOutput, 'similar' => $similar];
    }
    /**
     * Returns the server test files based on the version selected
     * @param int $version
     */

    public static function getFileNameByVersion(int $version)
    {
        $fileStr = Executer::executeFromCommandLine(
            'ls "$MY_VAR" | grep "$MY_VAR2" "$MY_VAR3"',
            10,
            [
                'MY_VAR' => NinjaUtils::SERVER_TEST_FILES_DIR,
                'MY_VAR2' => "-iE",
                'MY_VAR3' => "^v$version.*"
            ]
        );
        return array_filter(explode("\n", $fileStr));
    }
    /**
     * validates the njvm file.
     * @param UploadedFile $njvmFile
     */
    private function validateNjvmFile(UploadedFile $njvmFile)
    {
        if (NinjaUtils::isValidFileSize($njvmFile) === false) {
            throw new Exception('File too large');
        }
    }
    /**
     * validates the uploaded njvm file.
     * @param UploadedFile $testFile
     */
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