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
use DS\DiDock\Docker\Tools\Cli;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
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
            ->setName('use:cli')
            ->setDescription('Setup CLI tool on your system.')
            ->addOption('--image', '-i', InputOption::VALUE_REQUIRED)
            ->addOption('--alias', '-a', InputOption::VALUE_REQUIRED)
            ->addOption('--binary', '-b', InputOption::VALUE_REQUIRED)
        ;
    }

    /** {@inheritdoc} */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $image = $input->getOption('image');
        $alias = $input->getOption('alias');
        $binary = $input->getOption('binary');

        $cliDockerCommand = new Cli($alias, $image, $binary);

        $aliasWrapper = new AliasWrapper();
        $aliasWrapper->addAlias(new Alias($alias, (string) $cliDockerCommand));

//        $output->writeln('Update aliases.');
//        $output->write($aliasWrapper->updateAliases());

        $output->writeln(sprintf('All done. Now you can use your CLI tool, simple call "%s {your_command}".', $alias));
    }
}
