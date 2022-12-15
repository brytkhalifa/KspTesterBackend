<?php

namespace App\MyBundles;

use Exception;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Process\Process;

class KspTester
{

    public function getFileNameByVersion(int $version)
    {
        $fileStr =   Executer::executeFromCommandLine(
            'ls "$MY_VAR" | grep "$MY_VAR2" "$MY_VAR3"',
            ['MY_VAR' => '../resources/ksp_tester/bin_test_files', 'MY_VAR2' => "-iE", 'MY_VAR3' => "^v$version.*"]
        );
        return array_filter(explode("\n", $fileStr));
    }

    /**
     * test
     *
     * @param  UploadedFile $testFile
     * @param  UploadedFile $referenceFile
     * @param  int $version
     * @param  string $ip
     * @return array
     */
    public function test(UploadedFile $testFile, UploadedFile $userNjvmFile, int $version, string $ip, string $parameter = "1 2 3 4 5 6 7 8 9",  array $garbageCollectionData = [])
    {
    
        // get extension and check extension
        if (($extension = NinjaUtils::isValidExtension($testFile)) === false) {
            throw new Exception("Invalid extention  $testFile");
            // error 401: invalid extension
        }
        // check size of testfile. 
        if (NinjaUtils::isValidFileSize($testFile) === false || NinjaUtils::isValidFileSize($userNjvmFile) === false) {
            throw new Exception('File too large');
        }

        // create te name of the testFile based on the ip address.
        $filename  = NinjaUtils::getIpBasedFileName($testFile, $ip);
        // move the testFile to the new location
        NinjaUtils::moveFileToUploadDir($testFile, $filename);
        // move the referenceFile to a new location
        $userNjvmPath = NinjaUtils::moveFileToUserNjvmDir($userNjvmFile, $ip . '.njvm');

        $refOutput = ''; // container for reference Output
        $implOutput = ''; // container for ownImplementationOutput

        switch ($extension) {
            case 'nj':
                NinjaUtils::compile(NinjaUtils::getNinjaNameFromIP($ip), NinjaUtils::getAsmNameFromIP($ip), $version);
            case 'asm':
                NinjaUtils::assemble(NinjaUtils::getAsmNameFromIP($ip), NinjaUtils::getBinNameFromIP($ip), $version);
            case 'bin':
                NinjaUtils::makeExecutable(NinjaUtils::getBinNameFromIP($ip));
                // run with reference
                // try and catch all errors and set errors as output.
                try {
                    $refOutput = NinjaUtils::runReferenceBin(NinjaUtils::getBinNameFromIP($ip), $version, $parameter, $garbageCollectionData);
                } catch (Exception $e) {
                    $refOutput = $e->getMessage();
                }
                // run with own implementtion
                NinjaUtils::makeExecutable($userNjvmPath);
                try{
                    $implOutput = NinjaUtils::runBin(NinjaUtils::getBinNameFromIP($ip), $userNjvmPath, $parameter, $garbageCollectionData);
                }catch(Exception $e) {
                    $implOutput = $e->getMessage();
                }
            default:
        }

        //  return both outputs and an areSimilar 
        $similar = strcmp($implOutput, $refOutput) === 0;
        return  ['implementOutput' => $implOutput, 'referenceOutput' => $refOutput, 'similar' => $similar];
    }
}
