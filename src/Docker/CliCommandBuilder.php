<?php
/*
 * This file is part of the DiDock project.
 *
 * (c) Ilya Pokamestov <dario_swain@yahoo.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
*/

namespace DS\DiDock\Docker;

/**
 * Class CliCommandBuilder
 * @package DS\DiDock\Docker
 * @author Ilya Pokamestov <dario_swain@yahoo.com>
 */
class CliCommandBuilder
{
    const DOCKER_BINARY = 'docker';

    /** @var bool */
    protected $dockerCommand;
    /** @var string */
    protected $imageName;
    /** @var array */
    protected $options;
    /** @var  bool */
    protected $containerShellCommand;

    /**
     * CommandBuilder constructor.
     * @param string $dockerCommand
     */
    public function __construct($dockerCommand = 'run')
    {
        $this->dockerCommand = $dockerCommand;
    }

    /**
     * @param string $dockerCommand
     * @return $this
     */
    public function addDockerCommand($dockerCommand = 'run')
    {
        $this->dockerCommand = $dockerCommand;

        return $this;
    }

    /**
     * @param string $command
     * @return $this
     */
    public function addContainerCommand($command)
    {
        $this->containerShellCommand = $command;

        return $this;
    }

    /**
     * @return $this
     */
    public function removeImage()
    {
        $this->options['--rm'] = true;

        return $this;
    }

    /**
     * @return $this
     */
    public function detached()
    {
        $this->options['-d'] = true;

        return $this;
    }

    /**
     * @return $this
     */
    public function attachStdOut()
    {
        $this->attach('stdout');

        return $this;
    }

    /**
     * @return $this
     */
    public function attachStdIn()
    {
        $this->attach('stdin');

        return $this;
    }

    /**
     * @return $this
     */
    public function attachStdErr()
    {
        $this->attach('stderr');

        return $this;
    }

    /**
     * @return $this
     */
    public function attachAll()
    {
        $this->attachStdIn();
        $this->attachStdOut();
        $this->attachStdErr();

        return $this;
    }

    /**
     * @return $this
     */
    public function allocateTty()
    {
        $this->options['-t'] = true;

        return $this;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setContainerName($name)
    {
        $this->options['--name'] = $name;

        return $this;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setImageName($name)
    {
        $this->imageName = $name;

        return $this;
    }

    /**
     * @param string $workDir
     * @return $this
     */
    public function workDir($workDir)
    {
        $this->options['-w'] = $workDir;

        return $this;
    }

    /**
     * @param string $host
     * @param string $container
     * @return $this
     */
    public function addVolume($host, $container)
    {
        if (!isset($this->options['-v'])) {
            $this->options['-v'] = [$host => $container];
        }

        $this->options['-v'][$host] = $container;

        return $this;
    }

    /**
     * @param string $entryPoint
     * @return $this
     */
    public function entryPoint($entryPoint)
    {
        $this->options['--entrypoint'] = $entryPoint;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            '%s %s %s %s',
            self::DOCKER_BINARY,
            $this->dockerCommand,
            $this->optionsToString(),
            $this->imageName
        );
    }

    /**
     * @return string
     */
    protected function optionsToString()
    {
        $optionsString = '';
        foreach ($this->options as $option => $value) {
            if (is_bool($value)) {
                $optionsString = sprintf('%s %s', $optionsString, $option);
            }

            if (is_string($value)) {
                $optionsString = sprintf('%s %s="%s"', $optionsString, $option, $value);
            }

            if (is_array($value)) {
                foreach ($value as $optionKey => $optionValue) {
                    if (is_numeric($optionKey)) {
                        $optionsString = sprintf('%s %s %s', $optionsString, $option, $optionValue);
                    } else {
                        $optionsString = sprintf('%s %s %s:%s', $optionsString, $option, $optionKey, $optionValue);
                    }
                }
            }
        }

        return $optionsString;
    }

    /**
     * @param string $stream
     */
    protected function attach($stream)
    {
        if (isset($this->options['-a']) && is_array($this->options['-a'])) {
            if (!in_array($stream, $this->options['-a'])) {
                $this->options['-a'][] = $stream;
                return;
            }
        }

        $this->options['-a'] = [$stream];
    }
}
