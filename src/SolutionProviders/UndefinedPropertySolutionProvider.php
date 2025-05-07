<?php

namespace Spatie\ErrorSolutions\SolutionProviders;

use ErrorException;
use ReflectionClass;
use ReflectionProperty;
use Spatie\ErrorSolutions\Contracts\BaseSolution;
use Spatie\ErrorSolutions\Contracts\HasSolutionsForThrowable;
use Throwable;

class UndefinedPropertySolutionProvider implements HasSolutionsForThrowable
{
    protected const REGEX = '/([a-zA-Z\\\\]+)::\$([a-zA-Z]+)/m';
    protected const MINIMUM_SIMILARITY = 80;

    public function canSolve(Throwable $throwable): bool
    {
        if (! $throwable instanceof ErrorException) {
            return false;
        }

        if (is_null($this->getClassAndPropertyFromExceptionMessage($throwable->getMessage()))) {
            return false;
        }

        if (! $this->similarPropertyExists($throwable)) {
            return false;
        }

        return true;
    }

    public function getSolutions(Throwable $throwable): array
    {
        return [
            BaseSolution::create('Unknown Property')
                ->setSolutionDescription($this->getSolutionDescription($throwable)),
        ];
    }

    public function getSolutionDescription(Throwable $throwable): string
    {
        if (! $this->canSolve($throwable) || ! $this->similarPropertyExists($throwable)) {
            return '';
        }

        extract(
            /** @phpstan-ignore-next-line */
            $this->getClassAndPropertyFromExceptionMessage($throwable->getMessage()),
            EXTR_OVERWRITE,
        );

        $possibleProperty = $this->findPossibleProperty($class ?? '', $property ?? '');

        $class = $class ?? '';

        if (! $possibleProperty) {
            return "Did you mean another property in {$class}?";
        }

        return "Did you mean {$class}::\${$possibleProperty->name} ?";
    }

    protected function similarPropertyExists(Throwable $throwable): bool
    {
        /** @phpstan-ignore-next-line */
        extract($this->getClassAndPropertyFromExceptionMessage($throwable->getMessage()), EXTR_OVERWRITE);

        $possibleProperty = $this->findPossibleProperty($class ?? '', $property ?? '');

        return $possibleProperty !== null;
    }

    /**
     * @param string $message
     *
     * @return null|array<string, string>
     */
    protected function getClassAndPropertyFromExceptionMessage(string $message): ?array
    {
        if (! preg_match(self::REGEX, $message, $matches)) {
            return null;
        }

        return [
            'class' => $matches[1],
            'property' => $matches[2],
        ];
    }

    /**
     * @param class-string $class
     * @param string $invalidPropertyName
     *
     * @return ReflectionProperty|null
     */
    protected function findPossibleProperty(string $class, string $invalidPropertyName): ?ReflectionProperty
    {
        $properties = $this->getAvailableProperties($class);

        usort($properties, function (ReflectionProperty $a, ReflectionProperty $b) use ($invalidPropertyName) {
            similar_text($invalidPropertyName, $a->name, $percentageA);
            similar_text($invalidPropertyName, $b->name, $percentageB);

            return $percentageB <=> $percentageA; // Sort descending
        });

        $filteredProperties = array_values(array_filter($properties, function (ReflectionProperty $property) use ($invalidPropertyName) {
            similar_text($invalidPropertyName, $property->name, $percentage);

            return $percentage >= self::MINIMUM_SIMILARITY;
        }));

        return $filteredProperties[0] ?? null;
    }

    /**
     * @param class-string $class
     *
     * @return ReflectionProperty[]
     */
    protected function getAvailableProperties(string $class): array
    {
        $reflectionClass = new ReflectionClass($class);

        return $reflectionClass->getProperties();
    }
}
