<?php

namespace App\Controller;

use App\MyBundles\FileUtils;
use App\MyBundles\Ninja;
use App\MyBundles\NinjaUtils;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NinjaController extends AbstractController
{

    #[Route('/compile/{version}/{shortenCode}', name: 'compile', methods: ['POST'])]
    /**
     * Gets text containing ninja code and runs and returns the compiled asm text
     * @param Request $request
     * @param int $version
     * @param int $shortenCode $shortenCode if 1, inbuilt methods will be excluded from the asm code.
     * @throws Exception
     * @return JsonResponse|Response
     */
    public function compile(Request $request, int $version, int $shortenCode)
    {
        try {
            if ($version <= 3 || $version > 8) {
                throw new Exception("The selected version is not supported.");
            }
            $njCode = $request->get('value');
            if ($njCode === null) {
                throw new Exception('No value to compile');
            }

            $ip = NinjaUtils::generateFileNameFromIp($request->getClientIp());

            $ninja = new Ninja($ip, $version);
            $compiled = $ninja->getCompiledAsm($njCode, $shortenCode);

            $response = new Response($compiled);
            $response->headers->set('Content-Type', 'text/plain');
            return $response;
        } catch (Exception $e) {
            return $this->json(['error' => $e->getMessage()], 400);
        }
    }


    #[Route('/files', name: 'Get File List', methods: ['GET'])]
    /**
     * Returns the list of test files on the server
     * @param Request $request
     * @return JsonResponse
     */
    public function getTestFiles(Request $request)
    {
        try {
            $ip = NinjaUtils::generateFileNameFromIp($request->getClientIp());
            $ninja = new Ninja($ip);
            $testFiles = $ninja->getTestFilesList();
            return $this->json($testFiles);
        } catch (Exception $e) {
            return $this->json(['error' => $e->getMessage()], 400);
        }
    }

    #[Route('/files/{filename}', name: 'Get a Test File', methods: ['GET'])]
    /**
     * Returns the content of a test file with the passed filename
     * @param string $filename
     * @return JsonResponse
     */
    public function getTestFile(string $filename)
    {
        try {
            $fileContent = FileUtils::getContents(NinjaUtils::TEST_FILES_PATH . $filename);
            return $this->json(implode("", $fileContent));
        } catch (Exception $e) {
            return $this->json(['error' => $filename . " Existiert nicht"], 400);
        }
    }

    #[Route('/run/{version}', name: 'Run Code', methods: ['GET'])]
    /**
     * Runs the ninja code and returns the output of the virtual machine on success
     * @param Request $request
     * @param int $version
     * @return JsonResponse
     */
    public function runCode(Request $request, int $version = 8)
    {
        $ip = NinjaUtils::generateFileNameFromIp($request->getClientIp());

        $ninja = new Ninja($ip, $version);
        $arguments = $request->get('arguments') ?: NinjaUtils::DEFAULT_ARGUMENTS;
        try {
            $res = $ninja->runCode($arguments);
            return $this->json($res);
        } catch (Exception $e) {
            return $this->json(['error' => $e->getMessage()], 400);
        }
    }

    #[Route('/download/nj/{version}', name: 'Download ninja file', methods: ['GET'])]
    /**
     * Prepares the users ninja file for download
     * @param Request $request
     * @param int $version
     * @return BinaryFileResponse|JsonResponse
     */
    public function downloadNinja(Request $request, int $version)
    {
        try {
            $ip = NinjaUtils::generateFileNameFromIp($request->getClientIp());
            $ninja = new Ninja($ip, $version);
            $path = $ninja->handleNinjaDownload();
            $response = new BinaryFileResponse($path);
            // force to download
            $response->setContentDisposition(
                ResponseHeaderBag::DISPOSITION_ATTACHMENT,
                NinjaUtils::generateRandomFileName('.nj')
            );
            return $response;
        } catch (Exception $e) {
            return $this->json(['error' => $e->getMessage()], 400);
        }
    }

    #[Route('/download/asm/{version}', name: 'Download Assembler file', methods: ['GET'])]
    /**
     *  Prepares the users asm file for download
     * @param Request $request
     * @param int $version
     * @return BinaryFileResponse|JsonResponse
     */
    public function downloadAsm(Request $request, int $version = 8)
    {
        try {
            $ip = NinjaUtils::generateFileNameFromIp($request->getClientIp());
            $ninja = new Ninja($ip, $version);
            $path = $ninja->handleAsmDownload();
            $response = new BinaryFileResponse($path);
            // force to download
            $response->setContentDisposition(
                ResponseHeaderBag::DISPOSITION_ATTACHMENT,
                NinjaUtils::generateRandomFileName('.asm')
            );
            return $response;
        } catch (Exception $e) {
            return $this->json(['error' => $e->getMessage()], 400);
        }
    }

    #[Route('/download/bin/{version}', name: 'Download BinaryFile file', methods: ['GET'])]
    /**
     *  Prepares the users bin file for download
     * @param Request $request
     * @param int $version
     * @return BinaryFileResponse|JsonResponse
     */
    public function downloadBin(Request $request, int $version)
    {
        try {
            $ip = NinjaUtils::generateFileNameFromIp($request->getClientIp());
            $ninja = new Ninja($ip, $version);
            $path = $ninja->handleBinDownload();
            $response = new BinaryFileResponse($path);
            // force to download
            $response->setContentDisposition(
                ResponseHeaderBag::DISPOSITION_ATTACHMENT,
                NinjaUtils::generateRandomFileName('.bin')
            );
            return $response;
        } catch (Exception $e) {
            return $this->json(['error' => $e->getMessage()], 400);
        }
    }
}