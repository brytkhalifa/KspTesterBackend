<?php

namespace App\Controller;

use App\MyBundles\KspTester;
use App\MyBundles\NinjaUtils;
use Exception;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class KspTesterController
{
    #[Route('/getVersionFiles/{version}', name: 'Get Version Files', methods: ['GET'])]
    public function downloadAsm(Request $request, int $version)
    {
        try {
            $ip = $request->getClientIp();
            $tester = new KspTester($version, $ip);
            $res = $tester->getFileNameByVersion($version);
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
            $res = $tester
                ->withUserTestFile($userTestFile)
                ->withUserNjvmFile($userNjvmFile)
                ->withArguments($arguments)
                ->test();

            $res['params'] = $arguments;
            return  new JsonResponse(json_decode(json_encode($res)));
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }
    }

    #[Route('/test/own/withGC/{version}/{stack}/{heap}/{gcstats}/{gcpurge}', name: 'Own Test with Garbage Collector', methods: ['POST'])]

    public function testWithGC(Request $request, int $version, int $stack = 64, int $heap = 8192, int $gcstats = 0, int $gcpurge = 0)
    {

        // echo "$version, $gcstats, $gcpurge, $stack, $heap";
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
            $arguments = $request->get('arguments') ?? '1 2 3 4 5 6 7 8 9';

            $data =  [
                'version' => $version,
                'stackSize' => $stack ?: 64,
                'heapSize' => $heap ?: 8192,
                'gcstats' => $gcstats ? true : false,
                'gcpurge' => $gcpurge ? true : false,
            ];
            $tester = new KspTester($version, $ip);
            $res = $tester
                ->withUserNjvmFile($userNjvmFile)
                ->withUserTestFile($userTestFile)
                ->withArguments($arguments)
                ->withGarbageCollectionData($data)
                ->test();
            return  new JsonResponse($res);
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }
    }

    #[Route('/test/withGC/{fileName}/{version}/{stack}/{heap}/{gcstats}/{gcpurge}', name: 'Server Test with Garbage Collector', methods: ['POST'])]
    public function testFunctionalityWithGC(Request $request, string $fileName, int $version, int $stack = 64, int $heap = 8192, int $gcstats = 0, int $gcpurge = 0)
    {
        try {
            $userNjvmFile = $request->files->get('njvmFile');
            $serverTestFile = new UploadedFile(NinjaUtils::SERVER_TEST_FILES_DIR . $fileName, $fileName);


            if (isset($userNjvmFile) === false) {
                throw new Exception('Reference File not provided');
            }
            $ip = $request->getClientIp();
            $arguments = $request->get('arguments') ?: '1 2 3 4 5 6 7 8 9';


            $data =  [
                'version' => $version,
                'stackSize' => $stack ?? 64,
                'heapSize' => $heap ?? 8192,
                'gcstats' => $gcstats ? true : false,
                'gcpurge' => $gcpurge ? true : false,
            ];
            $tester = new KspTester($version, $ip);
            $res = $tester
                ->withUserNjvmFile($userNjvmFile)
                ->withServerTestFile($serverTestFile)
                ->withArguments($arguments)
                ->withGarbageCollectionData($data)
                ->test();

            return  new JsonResponse($res);
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }
    }
    #[Route('/test/{fileName}/{version}', name: 'Server Test without Garbage Collector', methods: ['POST'])]
    public function testFunctionality(Request $request, string $fileName, int $version)
    {
        try {
            $userNjvmFile = $request->files->get('njvmFile');

            $serverTestFile = new UploadedFile(NinjaUtils::SERVER_TEST_FILES_DIR . $fileName, $fileName);
            // throw new Exception(isset($serverTestFile) ? 'set' : 'not set'); 

            $arguments = $request->get('arguments') ?: '1 2 3 4 5 6 7 8 9';

            if (isset($userNjvmFile) === false) {
                throw new Exception('NJVM File from user not provided');
            }
            $ip = $request->getClientIp();
            $tester = new KspTester($version, $ip);
            $res = $tester
                ->withUserNjvmFile($userNjvmFile)
                ->withServerTestFile($serverTestFile)
                ->withArguments($arguments)
                ->test();

            return  new JsonResponse($res);
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }
    }
}
