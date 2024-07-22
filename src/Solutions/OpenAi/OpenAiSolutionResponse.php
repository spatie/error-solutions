<?php

namespace Spatie\ErrorSolutions\Solutions\OpenAi;

use Illuminate\Support\Str;

class OpenAiSolutionResponse
{
    protected string $rawText;

    public function __construct(string $rawText)
    {
        $this->rawText = trim($rawText);
    }

    public function description(): string
    {
        return $this->between('FIX', 'ENDFIX', $this->rawText);
    }
    
    public function links(): array
    {
        $rawText = Str::finish($this->rawText, 'ENDLINKS');    
        $textLinks = $this->between('LINKS', 'ENDLINKS', $rawText);
        $textLinks = explode(PHP_EOL, $textLinks);
        $links = [];
    
        foreach ($textLinks as $textLink) {
            $textLink = str_replace('\\', '\\\\', $textLink);
            $textLink = str_replace('\\\\\\', '\\\\', $textLink);
    
            $decodedLink = json_decode($textLink, true);
    
            if ($decodedLink !== null) {
                // Ajouter au tableau de liens
                $links[$decodedLink['title']] = $decodedLink['url'];
            }
        }

        return $links;
    }

    protected function between(string $start, string $end, string $text): string
    {
        $startPosition = strpos($text, $start);
        if ($startPosition === false) {
            return "";
        }

        $startPosition += strlen($start);
        $endPosition = strpos($text, $end, $startPosition);

        if ($endPosition === false) {
            return "";
        }

        return trim(substr($text, $startPosition, $endPosition - $startPosition));
    }
}
