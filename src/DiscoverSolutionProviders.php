<?php

namespace Spatie\ErrorSolutions;

use Spatie\ErrorSolutions\Contracts\HasSolutionsForThrowable;

class DiscoverSolutionProviders
{
    /** @var array<string, string> */
    protected array $config = [
        'ai' => 'SolutionProviders/OpenAi',
        'php' => 'SolutionProviders',
        'laravel' => 'SolutionProviders/Laravel',
    ];

    /**
     * @param array<string> $types
     *
     * @return array<class-string<HasSolutionsForThrowable>>
     */
    public static function for(array $types): array
    {
        if (in_array('php', $types)) {
            $types[] = 'ai';
        }

        return (new self($types))->get();
    }

    /**
     * @param array<string> $types
     */
    public function __construct(protected array $types)
    {

    }

    /** @return array<class-string<HasSolutionsForThrowable>> */
    public function get(): array
    {
        $providers = [];

        foreach ($this->types as $type) {
            $providers = array_merge($providers, $this->getProviderClassesForType($type));
        }

        return $providers;
    }

    /** @return array<class-string<HasSolutionsForThrowable>> */
    protected function getProviderClassesForType(string $type): array
    {
        $relativePath = $this->config[$type] ?? null;

        if (! $relativePath) {
            return [];
        }

        $namespace = $this->getNamespaceForPath($relativePath);

        $globPattern = __DIR__ . '/'  . $relativePath . '/*.php';

        $files = glob($globPattern);

        if (! $files) {
            return [];
        }

        $solutionProviders = array_map(function (string $solutionProviderFilePath) use ($namespace) {
            $fileName = pathinfo($solutionProviderFilePath, PATHINFO_FILENAME);

            /** @var class-string<HasSolutionsForThrowable> $fqcn */
            $fqcn = $namespace . '\\' . $fileName;

            $validClass = in_array(HasSolutionsForThrowable::class, class_implements($fqcn) ?: []);

            return $validClass ? $fqcn : null;
        }, $files);

        return array_values(array_filter($solutionProviders));
    }

    protected function getNamespaceForPath(string $relativePath): string
    {
        $namespacePath = str_replace('/', '\\', $relativePath);

        $namespace = 'Spatie\\ErrorSolutions\\' . $namespacePath;

        return $namespace;

    }
}
