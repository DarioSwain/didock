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

/**
 * Class Php
 * @package DS\DiDock\Docker\Tools
 * @author Ilya Pokamestov <dario_swain@yahoo.com>
 */
class Php
{
    protected $name;

    protected $image;

    public function __construct($name, $image)
    {
        $this->name = $name;
        $this->image = $image;
    }

    public function getCommandPattern()
    {
        return 'docker run --rm -it --name %s -v "$PWD":"$PWD" -w "$PWD" %s php';
    }

    public function __toString()
    {
        return sprintf($this->getCommandPattern(), $this->name, $this->image);
    }
}
