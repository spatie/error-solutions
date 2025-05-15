<?php

namespace Spatie\ErrorSolutions\SolutionProviders;

use ParseError;
use Spatie\ErrorSolutions\Contracts\BaseSolution;
use Spatie\ErrorSolutions\Contracts\HasSolutionsForThrowable;
use Throwable;

class MergeConflictSolutionProvider implements HasSolutionsForThrowable
{
    public function canSolve(Throwable $throwable): bool
    {
        if (! ($throwable instanceof ParseError)) {
            return false;
        }

        if (! $this->hasMergeConflictExceptionMessage($throwable)) {
            return false;
        }

        $file = (string)file_get_contents($throwable->getFile());

        if (! str_contains($file, '=======')) {
            return false;
        }
        if (! str_contains($file, '>>>>>>>')) {
            return false;
        }

        return true;
    }

    public function getSolutions(Throwable $throwable): array
    {
        $file = (string)file_get_contents($throwable->getFile());
        preg_match('/\>\>\>\>\>\>\> (.*?)\n/', $file, $matches);
        $source = $matches[1];

        $target = $this->getCurrentBranch(basename($throwable->getFile()));

        return [
            BaseSolution::create("Merge conflict from branch '$source' into $target")
                ->setSolutionDescription('You have a Git merge conflict. To undo your merge do `git reset --hard HEAD`'),
        ];
    }

    protected function getCurrentBranch(string $directory): string
    {
        $branch = "'".trim((string)shell_exec("cd {$directory}; git branch | grep \\* | cut -d ' ' -f2"))."'";

        if ($branch === "''") {
            $branch = 'current branch';
        }

        return $branch;
    }

    protected function hasMergeConflictExceptionMessage(Throwable $throwable): bool
    {
        if (str_starts_with($throwable->getMessage(), 'syntax error, unexpected token "<<"')) {
            return true;
        }

        return false;
    }
}
