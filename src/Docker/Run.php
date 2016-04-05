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
 * Class Run
 * @package DS\DiDock\Docker
 * @author Ilya Pokamestov <dario_swain@yahoo.com>
 */
class Run
{
    /** @var bool */
    protected $detached;
    /** @var  bool */
    protected $rm;
    /** @var  array */
    protected $volumes;
    /** @var string */
    protected $image;
    /** @var  string */
    protected $name;
    /** @var  array */
    protected $ports;
}
