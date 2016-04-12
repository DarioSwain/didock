<?php
/*
 * This file is part of the DiDock project.
 *
 * (c) Ilya Pokamestov <dario_swain@yahoo.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
*/

namespace DS\DiDock\Docker\Tools;

use DS\DiDock\Docker\CliCommandBuilder;

/**
 * Class Cli
 * @package DS\DiDock\Docker\Tools
 * @author Ilya Pokamestov <dario_swain@yahoo.com>
 */
class Cli
{
    /** @var CliCommandBuilder */
    protected $commandBuilder;

    /**
     * Cli constructor.
     * @param string $containerName
     * @param string $imageName
     * @param string $binary
     */
    public function __construct($containerName, $imageName, $binary)
    {
        $this->commandBuilder = new CliCommandBuilder();
        $this->commandBuilder->removeImage()
            ->attachAll()
            ->allocateTty()
            ->setContainerName($containerName)
            ->addVolume('${PWD}', '${PWD}')
            ->workDir('${PWD}')
            ->entryPoint($binary)
            ->setImageName($imageName);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->commandBuilder;
    }
}
