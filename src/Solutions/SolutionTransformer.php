<?php

namespace Spatie\ErrorSolutions\Solutions;

use Spatie\ErrorSolutions\Contracts\Solution;

class SolutionTransformer
{
    /** @return array<string, array<string,string>|string|false> */
    public function toArray(Solution $solution): array
    {
        return [
            'class' => get_class($solution),
            'title' => $solution->getSolutionTitle(),
            'links' => $solution->getDocumentationLinks(),
            'description' => $solution->getSolutionDescription(),
            'is_runnable' => false,
            'ai_generated' => $solution->aiGenerated ?? false,
        ];
    }
}
