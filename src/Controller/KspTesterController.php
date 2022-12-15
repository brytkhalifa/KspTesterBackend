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
    public function downloadAsm(int $version)
    {
        try {
            return new JsonResponse((new KspTester())->getFileNameByVersion($version));
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }
    }


    #[Route('/test/own/{version}', name: 'Own Test without Garbage Collector', methods: ['POST'])]
    public function testOwn(Request $request, int $version)
    {

        try {

            $testFile = $request->files->get('testFile');

            $njvmFile = $request->files->get('njvmFile');

            $arguments = $request->get('arguments') ?: '1 2 3 4 5 6 7 8 9';
            if (isset($testFile) === false) {
                throw new Exception('Test File not provided');
            }
            if (isset($njvmFile) === false) {
                throw new Exception('Reference File not provided');
            }
            $ip = $request->getClientIp();
            $res  = (new KspTester())->test($testFile, $njvmFile, $version, $ip, $arguments);
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
            $testFile = $request->files->get('testFile');

            $njvmFile = $request->files->get('njvmFile');
            if (isset($testFile) === false) {
                throw new Exception('Test File not provided');
            }
            if (isset($njvmFile) === false) {
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
            $res = (new KspTester())->test($testFile, $njvmFile, $version, $ip, $arguments, $data);
            $res['heap'] = $heap;
            $res['stack'] = $stack;
            $res['gcstats'] = $gcstats;
            return  new JsonResponse($res);
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }
    }

    #[Route('/test/withGC/{fileName}/{version}/{stack}/{heap}/{gcstats}/{gcpurge}', name: 'Test with Garbage Collector', methods: ['POST'])]
    public function testFunctionalityWithGC(Request $request, string $fileName, int $version, int $stack = 64, int $heap = 8192, int $gcstats = 0, int $gcpurge = 0)
    {
        try {
            $testFile = new UploadedFile('../resources/ksp_tester/bin_test_files/' . $fileName, $fileName);

            $njvmFile = $request->files->get('njvmFile');

            if (isset($njvmFile) === false) {
                throw new Exception('Reference File not provided');
            }
            $ip = $request->getClientIp();
            $arguments = $request->get('arguments') ?? '1 2 3 4 5 6 7 8 9';


            $data =  [
                'version' => $version,
                'stackSize' => $stack ?? 64,
                'heapSize' => $heap ?? 8192,
                'gcstats' => $gcstats ? true : false,
                'gcpurge' => $gcpurge ? true : false,
            ];

            return  new JsonResponse((new KspTester())->test($testFile, $njvmFile, $version, $ip, $arguments, $data));
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }
    }
    #[Route('/test/{fileName}/{version}', name: 'Test without Garbage Collector', methods: ['POST'])]
    public function testFunctionality(Request $request, string $fileName, int $version)
    {
        try {
            $njvmFile = $request->files->get('njvmFile');

            $testFile = new UploadedFile('../resources/ksp_tester/bin_test_files/' . $fileName, $fileName);

            $arguments = $request->get('arguments') ?? '1 2 3 4 5 6 7 8 9';

            if (isset($njvmFile) === false) {
                throw new Exception('Reference File not provided');
            }
            $ip = $request->getClientIp();

            return  new JsonResponse((new KspTester())->test($testFile, $njvmFile, $version, $ip, $arguments));
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }
    }
}
