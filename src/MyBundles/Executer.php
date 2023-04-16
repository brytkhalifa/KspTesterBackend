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
     * @param array $commands the commands to be executed
     * @param int  $timeout The max runtime in seconds
     * @return string The output of the process.
     */
    public static function execute(array $commands, int $timeout = 60)
    {
        $process = new Process($commands);
        $process->setTimeout($timeout);
        $process->run();
        if (!$process->isSuccessful()) {
            throw new Exception($process->getErrorOutput() . ' ' . $process->getOutput());
        }
        return $process->getOutput();
    }
    /**
     * Runs a string command. can be as simple as 'ls -l'
     * or with placeholder for argments like  'ls "$MY_VAR" | grep "$MY_VAR2" "$MY_VAR3"'
     * When there are arguments, them you need and arguments array which map the arguments to their respective values.
     * example: ['MY_VAR' => '-ls' ... ]
     * @param string $command The command to be excuted
     * @param int $timeout The max runtime in seconds
     * @param array $arguments the arguments needed if any.
     */
    public static function executeFromCommandLine(string $command, int $timeout = 60, array $arguments = [])
    {
        $process = Process::fromShellCommandline($command);
        $process->setTimeout($timeout);
        $process->run(null, $arguments);
        if (!$process->isSuccessful()) {
            throw new Exception(
                sprintf(
                    "%s %s\n%s: %s",
                    $process->getErrorOutput(),
                    $process->getOutput(),
                    $process->getExitCode(),
                    $process->getExitCodeText()
                )
            );
        }
        return $process->getOutput();
    }
}