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

/**
 * Class Alias
 * @package DS\DiDock\Bash\Alias
 * @author Ilya Pokamestov <dario_swain@yahoo.com>
 */
class Alias
{
    /** @var string */
    protected $name;
    /** @var string */
    protected $value;

    /**
     * Alias constructor.
     * @param string $name
     * @param string $value
     */
    public function __construct($name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('alias %s="%s"', $this->name, addcslashes($this->value, '"\\/'));
    }

    public static function fromAliasString($aliasDefinition)
    {
        //TODO: Create alias instance from string
    }
}
