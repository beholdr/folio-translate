<?php

namespace Beholdr\FolioTranslate\Actions;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Laravel\Folio\Folio;
use Laravel\Folio\MountPath;
use Laravel\Folio\Router;

class GetFolioView
{
    public function __invoke(string $url): ?string
    {
        $requestPath = Str::of(request()->getPathInfo());
        $mountPath = Arr::first(Folio::mountPaths(), fn (MountPath $path) => $requestPath->startsWith($path->baseUri));
        $router = new Router($mountPath);

        return $router->match(request(), $url)?->path;
    }
}
