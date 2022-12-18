<?php

declare(strict_types=1);

namespace App\Infrastructure\Console\Commands;

use App\AppBundle\Domains\EquationManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\{InputArgument, InputInterface};

#[AsCommand(
    name: 'app:solve-equation',
)]
class SolveEquationCommand extends Command
{
    protected static $defaultDescription = 'Решает квадратное уравнение';

    protected function configure(): void
    {
        $this
            ->addArgument('a', InputArgument::OPTIONAL, 'Значение а')
            ->addArgument('b', InputArgument::OPTIONAL, 'Значение b')
            ->addArgument('c', InputArgument::OPTIONAL, 'Значение c');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $a = $input->getArgument('a');
        $b = $input->getArgument('b');
        $c = $input->getArgument('c');

        $output->writeln([
            'Решение квадратного уравнения',
            '============',
            '',
        ]);

        $a = $this->inputFormatter($a);
        $b = $this->inputFormatter($b);
        $c = $this->inputFormatter($c);

        $equation = new EquationManager();
        try {
            $value = $equation::solve($a, $b, $c);
        } catch (\Exception $e) {
            $output->write($e->getMessage());
            return Command::FAILURE;
        }

        if ($value === []) {
            $output->write('Корней нет');
            return Command::SUCCESS;
        }
        [$x1, $x2] = $value;

        $output->writeln([
            'Корни квадратного уравнения:',
            'x1=' . $x1,
            'x2=' . $x2,
        ]);

        return Command::SUCCESS;
    }

    /**
     * Форматирует входные данные
     * @FIXME найти способ лучше (проблема в том, что символ "-" консоль воспринимает как название параметра,
     * поэтому отрицательные числа приходится передавать в ''
     *
     * @param string|null $value
     * @return float|null
     */
    private function inputFormatter(string|null $value): ?float
    {
        if ($value === null) {
            return null;
        }
        $value = str_replace("'", "", $value);
        return (float)$value;
    }
}
