<?php
/*
 * This file is part of the DiDock project.
 *
 * (c) Ilya Pokamestov <dario_swain@yahoo.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
*/

namespace DS\DiDock\Bash\Alias;

use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

/**
 * Class AliasWrapper
 * @package DS\DiDock\Bash\Alias
 * @author Ilya Pokamestov <dario_swain@yahoo.com>
 */
class AliasWrapper
{
    /** @var Filesystem */
    protected $fileSystem;
    /** @var string */
    protected $bashRcLocation = '/etc/bash.bashrc';
    /** @var string */
    protected $diDockAliasLocation = '/etc/.didock_bash_aliases';
    /** @var string */
    protected $diDockCommentLine = 'DiDock aliases';
    /** @var string */
    protected $profileContent = <<<EOD
# %s
if [ -f %s ]; then
    . %s
fi

EOD;

    public function __construct()
    {
        $this->fileSystem = new Filesystem();
        $this->createGlobalAliasesConfigurationFile();
    }

    public function addAlias(Alias $alias)
    {
        if (!$this->exists($alias)) {
            $this->writeAlias($alias);
        }
    }

    public function updateAliases()
    {
        //TODO: Not working now.
        $process = new Process(sprintf('source %s', $this->bashRcLocation));
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

         return $process->getOutput();
    }

    protected function exists(Alias $alias)
    {
        $diDockAliasesFile = fopen($this->diDockAliasLocation, 'r');

        $exist = false;
        while (($fileAlias = fgets($diDockAliasesFile)) !== false) {
            if ($fileAlias === (string)$alias) {
                $exist = true;
                break;
            }
        }

        if (!feof($diDockAliasesFile)) {
            throw new \Exception("Error: unexpected fgets() fail\n");
        }

        fclose($diDockAliasesFile);

        return $exist;
    }

    protected function writeAlias(Alias $alias)
    {
        $result = file_put_contents($this->diDockAliasLocation, ((string) $alias)."\n", FILE_APPEND);

        if (false === $result) {
            throw new \Exception('Write problem with '. $this->diDockAliasLocation);
        }
    }

    protected function createGlobalAliasesConfigurationFile()
    {
        if (!$this->fileSystem->exists($this->bashRcLocation)) {
            throw new FileNotFoundException('bash hrc file not found in '.$this->bashRcLocation);
        }

        $bashRcContent = file_get_contents($this->bashRcLocation);

        if (false !== strpos($bashRcContent, $this->diDockCommentLine)) {
            return;
        }

        $result = file_put_contents(
            $this->bashRcLocation,
            sprintf(
                $this->profileContent,
                $this->diDockCommentLine,
                $this->diDockAliasLocation,
                $this->diDockAliasLocation
            ),
            FILE_APPEND
        );

        if (false === $result) {
            throw new \Exception('Impossible to change '. $this->bashRcLocation);
        }

        if (!$this->fileSystem->exists($this->diDockAliasLocation)) {
            $this->fileSystem->touch($this->diDockAliasLocation);
        }
    }
}
