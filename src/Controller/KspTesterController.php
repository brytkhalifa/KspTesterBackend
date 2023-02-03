<?php

namespace App\Controller;

use App\MyBundles\KspTester;
use App\MyBundles\NinjaUtils;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class KspTesterController extends AbstractController
{
    /**
     * used to inject logger
     * @var LoggerInterface
     *
     *private $logger;
     *public function __construct(LoggerInterface $logger)
     *{
     *$this->logger = $logger;
     *}
     */

    #[Route('/getVersionFiles/{version}', name: 'Get Version Files', methods: ['GET'])]
    public function downloadAsm(Request $request, int $version)
    {
        try {
            $ip = $request->getClientIp();
            $tester = new KspTester($version, $ip);
            $res = $tester->getFileNameByVersion();
            return new JsonResponse($res);
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }
    }


    #[Route('/test/own/{version}', name: 'Own Test without Garbage Collector', methods: ['POST'])]
    public function testOwn(Request $request, int $version)
    {
        try {

            $userTestFile = $request->files->get('testFile');
            $userNjvmFile = $request->files->get('njvmFile');

            $arguments = $request->get('arguments') ?: '1 2 3 4 5 6 7 8 9';

            if (isset($userTestFile) === false) {
                throw new Exception('Test File not provided');
            }
            if (isset($userNjvmFile) === false) {
                throw new Exception('Reference File not provided');
            }
            $ip = $request->getClientIp();
            $tester = new KspTester($version, $ip);
            $res = [];
            $fileName = $userTestFile->getClientOriginalName();
            $res[$fileName] = $tester
                ->withUserTestFile($userTestFile)
                ->withUserNjvmFile($userNjvmFile)
                ->withArguments($arguments)
                ->test();
            return new JsonResponse($res);
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }
    }

    #[Route('/test/own/withGC/{version}/{stack}/{heap}/{gcstats}/{gcpurge}',
    name: 'Own Test with Garbage Collector', methods: ['POST'])]

    public function testWithGC(
        Request $request, int $version, int $stack = 64, int $heap = 8192, int $gcstats = 0, int $gcpurge = 0
    )
    {
        try {
            $userTestFile = $request->files->get('testFile');

            $userNjvmFile = $request->files->get('njvmFile');
            if (isset($userTestFile) === false) {
                throw new Exception('Test File not provided');
            }
            if (isset($userNjvmFile) === false) {
                throw new Exception('Reference File not provided');
            }
            $ip = $request->getClientIp();
            $arguments = $request->get('arguments') ?: '1 2 3 4 5 6 7 8 9';

            $data = [
                'version' => $version,
                'stackSize' => $stack ?: 64,
                'heapSize' => $heap ?: 8192,
                'gcstats' => $gcstats ? true : false,
                'gcpurge' => $gcpurge ? true : false,
            ];
            $tester = new KspTester($version, $ip);
            $res = [];
            $fileName = $userTestFile->getClientOriginalName();
            $res[$fileName] = $tester
                ->withUserNjvmFile($userNjvmFile)
                ->withUserTestFile($userTestFile)
                ->withArguments($arguments)
                ->withGarbageCollectionData($data)
                ->test();
            return new JsonResponse($res);
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }
    }

    #[Route('/testServerFiles/withGC/{version}/{stack}/{heap}/{gcstats}/{gcpurge}',
    name: 'Test server files with Garbage Collector', methods: ['POST'])]
    public function testFunctionalityWithGC(
        Request $request, int $version, int $stack = 64, int $heap = 8192, int $gcstats = 0, int $gcpurge = 0
    )
    {
        try {
            $userNjvmFile = $request->files->get('njvmFile');
            $serverFiles = json_decode($request->get("serverTests")) ?: [];

            if (isset($userNjvmFile) === false) {
                throw new Exception('Reference File not provided');
            }
            $ip = $request->getClientIp();
            $arguments = $request->get('arguments') ?: '1 2 3 4 5 6 7 8 9';

            $data = [
                'version' => $version,
                'stackSize' => $stack ?: 64,
                'heapSize' => $heap ?: 8192,
                'gcstats' => $gcstats ? true : false,
                'gcpurge' => $gcpurge ? true : false,
            ];
            $tester = new KspTester($version, $ip);
            $command = $tester
                ->withUserNjvmFile($userNjvmFile)
                ->withArguments($arguments)
                ->withGarbageCollectionData($data);
            $res = [];
            foreach ($serverFiles as $serverFile) {
                $serverTestFile = new UploadedFile(NinjaUtils::SERVER_TEST_FILES_DIR . $serverFile, $serverFile);
                $res[$serverFile] = $command
                    ->withServerTestFile($serverTestFile)
                    ->test();
            }
            return new JsonResponse($res);
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }
    }

    #[Route('/testServerFiles/{version}',
    name: 'Test server files without Garbage Collector', methods: ['POST'])]
    public function testAllFiles(Request $request, int $version)
    {
        try {

            $userNjvmFile = $request->files->get('njvmFile');
            $arguments = $request->get('arguments') ?: '1 2 3 4 5 6 7 8 9';
            $serverFiles = json_decode($request->get("serverTests")) ?: [];
            // use logger like this $this->logger->info(implode("", $files));
            if (isset($userNjvmFile) === false) {
                throw new Exception('NJVM File from user not provided');
            }
            $ip = $request->getClientIp();
            $tester = new KspTester($version, $ip);

            $command = $tester
                ->withUserNjvmFile($userNjvmFile)
                ->withArguments($arguments);
            $res = [];
            foreach ($serverFiles as $serverFile) {
                $serverTestFile = new UploadedFile(NinjaUtils::SERVER_TEST_FILES_DIR . $serverFile, $serverFile);
                $res[$serverFile] = $command
                    ->withServerTestFile($serverTestFile)
                    ->test();
            }
            return new JsonResponse($res);
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }
    }
}