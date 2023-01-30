<?php

namespace App\Twig\Extension;

use Twig\TwigFilter;
use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;
use App\Twig\Runtime\YoutubeExtensionRuntime;
use RicardoFiorani\Matcher\VideoServiceMatcher;


class YoutubeExtension extends AbstractExtension
{
    private $youtubeParser;

    public function __construct()
    {
        $this->youtubeParser = new VideoServiceMatcher();
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('youtube_thumbnail', [$this, 'youtubeThumbnail']),
            new TwigFilter('youtube_player', [$this, 'youtubePlayer']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('function_name', [$this, 'doSomething']),
        ];
    }

    public function youtubeThumbnail($value)
    {
        $video = $this->youtubeParser->parse($value);
        return $video->getLargestThumbnail();
    }

    public function youtubePlayer($value)
    {
        $video = $this->youtubeParser->parse($value);
        return $video->getEmbedCode('100%', 500, true, true);
    }
}
