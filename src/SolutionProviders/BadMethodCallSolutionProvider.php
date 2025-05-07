<?php

namespace Spatie\ErrorSolutions\SolutionProviders;

use BadMethodCallException;
use ReflectionClass;
use ReflectionMethod;
use Spatie\ErrorSolutions\Contracts\BaseSolution;
use Spatie\ErrorSolutions\Contracts\HasSolutionsForThrowable;
use Throwable;

class BadMethodCallSolutionProvider implements HasSolutionsForThrowable
{
    protected const REGEX = '/([a-zA-Z\\\\]+)::([a-zA-Z]+)/m';

    public function canSolve(Throwable $throwable): bool
    {
        if (! $throwable instanceof BadMethodCallException) {
            return false;
        }

        if (is_null($this->getClassAndMethodFromExceptionMessage($throwable->getMessage()))) {
            return false;
        }

        return true;
    }

    public function getSolutions(Throwable $throwable): array
    {
        return [
            BaseSolution::create('Bad Method Call')
            ->setSolutionDescription($this->getSolutionDescription($throwable)),
        ];
    }

    public function getSolutionDescription(Throwable $throwable): string
    {
        if (! $this->canSolve($throwable)) {
            return '';
        }

        /** @phpstan-ignore-next-line  */
        extract($this->getClassAndMethodFromExceptionMessage($throwable->getMessage()), EXTR_OVERWRITE);

        $possibleMethod = $this->findPossibleMethod($class ?? '', $method ?? '');

        $class ??= 'UnknownClass';

        return "Did you mean {$class}::{$possibleMethod?->name}() ?";
    }

    /**
     * @param string $message
     *
     * @return null|array<string, mixed>
     */
    protected function getClassAndMethodFromExceptionMessage(string $message): ?array
    {
        if (! preg_match(self::REGEX, $message, $matches)) {
            return null;
        }

        return [
            'class' => $matches[1],
            'method' => $matches[2],
        ];
    }

    /**
     * @param class-string $class
     * @param string $invalidMethodName
     *
     * @return \ReflectionMethod|null
     */
    protected function findPossibleMethod(string $class, string $invalidMethodName): ?ReflectionMethod
    {
        $methods = $this->getAvailableMethods($class);

        usort($methods, function (ReflectionMethod $a, ReflectionMethod $b) use ($invalidMethodName) {
            similar_text($invalidMethodName, $a->name, $percentA);
            similar_text($invalidMethodName, $b->name, $percentB);

            return $percentB <=> $percentA;
        });

        return $methods[0] ?? null;
    }

    /**
     * @param class-string $class
     *
     * @return ReflectionMethod[]
     */
    protected function getAvailableMethods(string $class): array
    {
        $refClass = new ReflectionClass($class);

        return $refClass->getMethods();
    }
}
