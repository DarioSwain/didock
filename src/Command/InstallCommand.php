<?php
/*
 * This file is part of the DiDock project.
 *
 * (c) Ilya Pokamestov <dario_swain@yahoo.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
*/

namespace DS\DiDock\Command;

use DS\DiDock\Bash\Alias\Alias;
use DS\DiDock\Bash\Alias\AliasWrapper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class InstallCommand
 * @package DS\DiDock\Command
 * @author Ilya Pokamestov <dario_swain@yahoo.com>
 */
class InstallCommand extends Command
{
    /** {@inheritdoc} */
    protected function configure()
    {
        $this
            ->setName('install')
            ->setDescription('Install DiDock service.')
        ;
    }

    /** {@inheritdoc} */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $aliasWrapper = new AliasWrapper();
        $aliasWrapper->addAlias(new Alias('la', 'ls -la'));
        $output->writeln('Done.');
    }
}
