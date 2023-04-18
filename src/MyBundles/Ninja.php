<?php

namespace App\MyBundles;

use Exception;

/**
 * Ninja
 * Handles everthing which has to do with the ninja editor. 
 */
class Ninja
{
    private string $address; // the md5 representation of the ip address
    private string $ninjaFileName; // the ninja file name
    private string $asmFileName; // the assembler file name
    private string $binFileName; // the binary file name.
    private int $version; // the version used to compile the ninja file

    /**
     * __construct
     * creates the default names of the files based on the Ip address
     * @param  string $ip The request from the router.
     * @param  int $version The request from the router.
     */
    public function __construct(string $ip, int $version = 8)
    {
        $this->address = $ip;
        $this->version = $version;
        $this->ninjaFileName = NinjaUtils::attachNinjaExtension($this->address);
        $this->asmFileName = NinjaUtils::attachAsmExtension($this->address);
        $this->binFileName = NinjaUtils::attachBinExtension($this->address);
    }

    /**
     * compiles the ninja file to asm file and returns its content
     *
     * @param string $content
     * @return string the content of the asm file
     * @throws Exception
     */
    public function getCompiledAsm(string $content, int $shortenCode)
    {
        // write the value to the file
        FileUtils::writeToFile($content, $this->getNinjaFileFullPath());
        // compile the nj file to asm
        NinjaUtils::compile($this->getNinjaFileFullPath(), $this->getAsmFileFullPath(), $this->version);
        // return contents of the asm file
        return NinjaUtils::getAsmContents($this->getAsmFileFullPath(), $this->version, $shortenCode);
    }
    /**
     * Returns the names of all ninja test files on the server
     */
    public function getTestFilesList()
    {
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
        NinjaUtils::assemble($this->getAsmFileFullPath(), $this->getBinFileFullPath(), $this->version);
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

    /**
     * @param string $arguments The arguments needed to run the code
     */
    public function runCode(string $arguments = NinjaUtils::DEFAULT_ARGUMENTS)
    {
        NinjaUtils::assemble($this->getAsmFileFullPath(), $this->getBinFileFullPath(), $this->version);
        NinjaUtils::makeExecutable($this->getBinFileFullPath());
        return NinjaUtils::runBin(
            $this->getBinFileFullPath(),
            NinjaUtils::getNinjaRefFile($this->version),
            $arguments,
            []
        );
    }
}