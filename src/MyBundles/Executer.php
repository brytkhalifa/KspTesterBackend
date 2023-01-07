<?php

namespace App\MyBundles;

use Symfony\Component\Process\Process;
use Exception;

class Executer
{

    /**
     * executes process in order of the elements in the array.
     *
     * Forexample execute(['ls', '-l' , '/home']) will execute the process 'ls -l /home'.
     * @return string The output of the process.
     */
    public static function execute(array $commands)
    {
        $process = new Process($commands);
        $process->run();
        if (!$process->isSuccessful()) {
            throw new Exception($process->getErrorOutput() . ' ' . $process->getOutput());
        }
        return $process->getOutput();
    }

    public static function executeFromCommandLine(string $command, int $timeout = 60, array $arguments = [])
    {
        $process = Process::fromShellCommandline($command);
        $process->setTimeout($timeout);
        $process->run(null, $arguments);
        if (!$process->isSuccessful()) {
            throw new Exception(sprintf("%s %s\n%s: %s", $process->getErrorOutput(), $process->getOutput(), $process->getExitCode(), $process->getExitCodeText()));
        }
        return $process->getOutput();
    }
}
