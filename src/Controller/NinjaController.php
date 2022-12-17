<?php

namespace App\Controller;

use App\MyBundles\FileUtils;
use App\MyBundles\Ninja;
use App\MyBundles\NinjaUtils;
use Exception;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NinjaController
{

    #[Route('/compile', name: 'compile', methods: ['POST'])]
    /**
     * compile
     *
     * @param  mixed $request
     * @return Response|JsonResponse 
     */
    public function compile(Request $request)
    {
        try {
            $ninja = new Ninja($request);
            $compiled = $ninja->getCompiledAsm(); // create 
            $response =  new Response($compiled);
            $response->headers->set('Content-Type', 'text/plain');
            return $response;
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }
    }


    #[Route('/files', name: 'Get File List', methods: ['GET'])]
    public function getTestFiles(Request $request)
    {
        try {
            $ninja = new Ninja($request);
            $testFiles = $ninja->getTestFilesList();
            //var_dump($testFiles);
            $response = new JsonResponse($testFiles);
            return $response;
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }
    }

    #[Route('/files/{filename}', name: 'Get a Test File', methods: ['GET'])]
    public function getTestFile(Request $request, string $filename)
    {
        try {
            $fileContent = FileUtils::getContents(NinjaUtils::TEST_FILES_PATH . $filename);
            $response =  new JsonResponse(implode("", $fileContent));
            return $response;
        } catch (Exception $e) {
            return new JsonResponse(['error' => $filename . " Existiert nicht"], 400);
        }
    }


    #[Route('/download/nj', name: 'Download ninja file', methods: ['GET'])]
    /**
     * downloadNinja
     *
     * @param  Request $request
     * @return BinaryFileResponse
     */
    public function downloadNinja(Request $request)
    {
        try {
            $ninja = new Ninja($request);
            $path = $ninja->handleNinjaDownload();
            return new BinaryFileResponse($path);
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }
    }

    #[Route('/download/asm', name: 'Download Assembler file', methods: ['GET'])]
    /**
     * downloadAsm
     *
     * @param  Request $request
     * @return BinaryFileResponse
     */
    public function downloadAsm(Request $request)
    {
        try {
            $ninja = new Ninja($request);
            $path = $ninja->handleAsmDownload();
            return new BinaryFileResponse($path);
            
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }
    }

    #[Route('/download/bin', name: 'Download BinaryFile file', methods: ['GET'])]
    /**
     * downloadBin
     *
     * @param  Request $request
     * @return BinaryFileResponse
     */
    public function downloadBin(Request $request)
    {
        try {
            $ninja = new Ninja($request);
            $path = $ninja->handleBinDownload();
            return new BinaryFileResponse($path);
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }
    }
}
