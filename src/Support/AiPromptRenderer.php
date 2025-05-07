<?php

namespace Spatie\ErrorSolutions\Support;

class AiPromptRenderer
{
    /**
     * @param array<string, mixed> $data
     *
     * @return void
     */
    public function render(array $data, string $viewPath): void
    {
        $viewFile = $viewPath;

        extract($data, EXTR_OVERWRITE);

        include $viewFile;
    }

    /**
     * @param array<string, mixed> $data
     */
    public function renderAsString(array $data, string $viewPath): string
    {
        ob_start();

        $this->render($data, $viewPath);

        $rendered = ob_get_clean();

        if($rendered === false) {
            throw new \RuntimeException('Failed to get the output buffer content.');
        }

        return $rendered;
    }
}
