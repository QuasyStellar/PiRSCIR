<?php

/**
 * Safely executes a shell command and returns its output.
 *
 * @param string $command The shell command to execute.
 * @return string The output of the command, or an error message if execution fails.
 */
function executeCommand(string $command): string
{
    // Sanitize the command to prevent command injection, though exact sanitization
    // depends on the expected commands. For this exercise, we'll assume basic
    // commands without user-provided arguments in the command itself.
    // escapeshellcmd() can prevent command injection, but also escapes arguments
    // which might not be desired. For this specific case where we define the commands,
    // we can be more direct.
    
    // Using proc_open for more control and to capture stderr
    $descriptorspec = array(
        0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
        1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
        2 => array("pipe", "w")   // stderr is a pipe that the child will write to
    );

    $process = proc_open($command, $descriptorspec, $pipes);

    if (is_resource($process)) {
        // Close stdin
        fclose($pipes[0]);

        // Read stdout and stderr
        $stdout = stream_get_contents($pipes[1]);
        fclose($pipes[1]);

        $stderr = stream_get_contents($pipes[2]);
        fclose($pipes[2]);

        // It is important that you close any pipes before calling
        // proc_close in order to avoid a deadlock
        $returnValue = proc_close($process);

        if ($returnValue === 0) {
            return trim($stdout);
        } else {
            return "Error executing command (exit code: $returnValue):\n" . trim($stderr);
        }
    } else {
        return "Failed to execute command: $command";
    }
}

?>