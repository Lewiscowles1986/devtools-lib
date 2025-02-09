<?php

declare(strict_types=1);

namespace Ramsey\Test\Dev\Tools\Composer\Command;

use Ramsey\Dev\Tools\Composer\Command\LintSyntaxCommand;
use Symfony\Component\Console\Input\InputInterface;

class LintSyntaxCommandTest extends ProcessCommandTestCase
{
    protected function setUp(): void
    {
        $this->commandClass = LintSyntaxCommand::class;
        $this->baseName = 'lint:syntax';
        $this->processCommand = [
            '/path/to/bin-dir/parallel-lint',
            '--colors',
            'src',
            'tests',
        ];

        parent::setUp();

        $this->input->allows()->getOption('parallel-lint-help')->andReturnFalse();

        $this->input->allows()->getArguments()->andReturnNull();
    }

    public function testWithParallelLintHelpOption(): void
    {
        $this->input = $this->mockery(InputInterface::class);
        $this->input->allows()->getOption('parallel-lint-help')->andReturnTrue();
        $this->input->allows()->getArguments()->andReturn([
            'args' => ['--bar'],
        ]);

        $this->processCommand = ['/path/to/bin-dir/parallel-lint', '--colors', '--help'];

        $this->testRun();
    }

    public function testWhenPassingArguments(): void
    {
        $this->input = $this->mockery(InputInterface::class);
        $this->input->expects()->getArguments()->andReturn([
            'args' => ['--bar', '--baz'],
        ]);

        $this->processCommand = [
            '/path/to/bin-dir/parallel-lint',
            '--colors',
            '--bar',
            '--baz',
        ];

        $this->testRun();
    }
}
