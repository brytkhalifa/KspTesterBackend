<?php

namespace App\MyBundles;

use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Process\Process;

/**
 * Ninja
 * Handles everthing which has to do with the ninja editor. 
 */
class Ninja
{

    private const ERROR_EXPRESSIONS = [
        'My brain just exploded. I dont know what is wrong with you code. Maybe redeclaration of a local variable?'
    ];
    private $request;
    private string $address;
    private string $ninjaFileName;
    private string $asmFileName;
    private string $binFileName;

    /**
     * __construct
     * creates the default names of the files based on the Ip address
     * @param  Request $request The request from the router. 
     */
    public function __construct(Request $request)
    {
        $this->address = $request->getClientIp();
        $this->request = $request;
        $this->ninjaFileName = NinjaUtils::attachNinjaExtension($this->address);
        $this->asmFileName =  NinjaUtils::attachAsmExtension($this->address);
        $this->binFileName =  NinjaUtils::attachBinExtension($this->address);
    }

    /**
     * compiles the ninja file to asm file and returns its content
     *
     * @return string the content of the asm file
     * @throws Exception
     */
    public function getCompiledAsm()
    {
        $body =  ($this->request->toArray());
        if (!array_key_exists('value', $body)) {
            throw new Exception('No value to compile');
        }
        $content = $body['value'];
        // write the value to the file
        FileUtils::writeToFile($content, $this->getNinjaFileFullPath());
        // compile the nj file to asm
        NinjaUtils::compile($this->getNinjaFileFullPath(), $this->getAsmFileFullPath(), 8);
        // return contents of the asm file 
        return NinjaUtils::getAsmContents($this->getAsmFileFullPath());
    }

    public function getTestFilesList () {
        return NinjaUtils::getDirectoryContents(NinjaUtils::TEST_FILES_PATH);
    }

   
    /**
     * Handles everything needed to download the asm file and returns the path of the asm file
     * @return string the full path of the asm file
     */
    public function handleAsmDownload()
    {
        return $this->getAsmFileFullPath();
    }
    /**
     * Handles everything needed to download the binary file and returns the path of the binary file
     * @return string the full path of the binary file
     */
    public function handleBinDownload()
    {
        NinjaUtils::assemble($this->getAsmFileFullPath(), $this->getBinFileFullPath(), 8);
        return $this->getBinFileFullPath();
    }
    /**
     * Handles everything needed to download the ninja file and returns the path of the ninja file
     * @return string the full path of the ninja file
     */
    public function handleNinjaDownload()
    {
        return $this->getNinjaFileFullPath();
    }

    /**
     * @return string the full path of the asm file
     */
    public function getAsmFileFullPath()
    {
        return NinjaUtils::ASM_FILE_PATH . $this->asmFileName;
    }
    /**
     * @return string the full path of the ninja file
     */
    public function getNinjaFileFullPath()
    {
        return NinjaUtils::NINJA_FILE_PATH . $this->ninjaFileName;
    }

    /**
     * @return string the full path of the binary file
     */
    public function getBinFileFullPath()
    {
        return NinjaUtils::BIN_FILE_PATH . $this->binFileName;
    }
}
