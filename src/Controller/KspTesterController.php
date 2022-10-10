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
    #[Route('/test/{fileName}/{version}', name: 'Test without Garbage Collector', methods: ['POST'])]
    public function testFunctionality(Request $request, string $fileName, int $version)
    {
        try {
            $referenceFile = $request->files->get('referenceFile');

            $testFile = new UploadedFile('../resources/ksp_tester/bin_test_files/' . $fileName, $fileName);

            $parameter = $request->get('parameter') ?? '1 2 3 4 5 6 7 8 9';

            if (isset($referenceFile) === false) {
                throw new Exception('Reference File not provided');
            }
            $ip = $request->getClientIp();

            return  new JsonResponse((new KspTester())->test($testFile, $referenceFile, $version, $ip, $parameter));
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }
    }
    #[Route('/test/own/withGC/{fileName}/{version}/{stack}/{heap}/{gcstats}/{gcpurge}', name: 'Test with Garbage Collector', methods: ['POST'])]
    public function testFunctionalityWithGC(Request $request, string $fileName, int $version, int $stack = 64, int $heap = 8192, int $gcstats = 0, int $gcpurge = 0)
    {
        try {
            $testFile = new UploadedFile('../resources/ksp_tester/bin_test_files/' . $fileName, $fileName);

            $referenceFile = $request->files->get('referenceFile');

            if (isset($referenceFile) === false) {
                throw new Exception('Reference File not provided');
            }
            $ip = $request->getClientIp();
            $parameter = $request->get('parameter') ?? '1 2 3 4 5 6 7 8 9';
            

            $data =  [
                'version' => $version,
                'stackSize' => $stack ?? 64,
                'heapSize' => $heap ?? 8192,
                'gcstats' => $gcstats ? true : false,
                'gcpurge' => $gcpurge ? true : false,
            ];

            return  new JsonResponse((new KspTester())->test($testFile, $referenceFile, $version, $ip, $parameter, $data));
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }
    }

    #[Route('/test/own/{version}', name: 'Own Test without Garbage Collector', methods: ['POST'])]
    public function testOwn(Request $request, int $version)
    {

        try {
            $testFile = $request->files->get('testFile');

            $referenceFile = $request->files->get('referenceFile');

            $parameter = $request->get('parameter') ?? '1 2 3 4 5 6 7 8 9';
            if (isset($testFile) === false) {
                throw new Exception('Test File not provided');
            }
            if (isset($referenceFile) === false) {
                throw new Exception('Reference File not provided');
            }
            $ip = $request->getClientIp();
            return  new JsonResponse((new KspTester())->test($testFile, $referenceFile, $version, $ip, $parameter));
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }
    }

    #[Route('/test/own/withGC/{version}/{stack}/{heap}/{gcstats}/{gcpurge}', name: 'Own Test with Garbage Collector', methods: ['POST'])]

    public function testWithGC(Request $request, int $version, int $stack = 64, int $heap = 8192, int $gcstats = 0, int $gcpurge = 0)
    {

        echo "$version, $gcstats, $gcpurge, $stack, $heap";
        try {
            $testFile = $request->files->get('testFile');

            $referenceFile = $request->files->get('referenceFile');
            if (isset($testFile) === false) {
                throw new Exception('Test File not provided');
            }
            if (isset($referenceFile) === false) {
                throw new Exception('Reference File not provided');
            }
            $ip = $request->getClientIp();
            $parameter = $request->get('parameter') ?? '1 2 3 4 5 6 7 8 9';

            $data =  [
                'version' => $version,
                'stackSize' => $stack ?? 64,
                'heapSize' => $heap ?? 8192,
                'gcstats' => $gcstats ? true : false,
                'gcpurge' => $gcpurge ? true : false,
            ];

            return  new JsonResponse((new KspTester())->test($testFile, $referenceFile, $version, $ip, $parameter, $data));
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }
    }
}
