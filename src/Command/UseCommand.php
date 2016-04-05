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
use DS\DiDock\Docker\Tools\Php;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class UseCommand
 * @package DS\DiDock\Command
 * @author Ilya Pokamestov <dario_swain@yahoo.com>
 */
class UseCommand extends Command
{
    /** {@inheritdoc} */
    protected function configure()
    {
        $this
            ->setName('use')
            ->setDescription('Setup software on your system.')
            ->addArgument('image', InputArgument::REQUIRED)
            ->addArgument('keyword', InputArgument::REQUIRED)
            ->addArgument('alias', InputArgument::REQUIRED)
        ;
    }

    /** {@inheritdoc} */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $image = $input->getArgument('image');
        $alias = $input->getArgument('alias');

        $phpCommand = new Php($alias, $image);

        $aliasWrapper = new AliasWrapper();
        $aliasWrapper->addAlias(new Alias($alias, (string) $phpCommand));
        $output->writeln('Done.');
    }
}
