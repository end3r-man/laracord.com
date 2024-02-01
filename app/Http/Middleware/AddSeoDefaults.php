<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use romanzipp\Seo\Structs\Link as LinkMeta;
use romanzipp\Seo\Structs\Meta;
use romanzipp\Seo\Structs\Meta\OpenGraph;
use romanzipp\Seo\Structs\Meta\Twitter;
use Symfony\Component\HttpFoundation\Response;

class AddSeoDefaults
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        seo()->charset();
        seo()->viewport();

        seo()->csrfToken();

        seo()->addMany([
            LinkMeta::make()
                ->rel('apple-touch-icon')
                ->attr('sizes', '180x180')
                ->href('/apple-touch-icon.png'),

            LinkMeta::make()
                ->rel('icon')
                ->attr('sizes', '32x32')
                ->attr('type', 'image/png')
                ->href('/favicon-32x32.png'),

            LinkMeta::make()
                ->rel('icon')
                ->attr('sizes', '16x16')
                ->attr('type', 'image/png')
                ->href('/favicon-16x16.png'),

            LinkMeta::make()
                ->rel('manifest')
                ->href('/site.webmanifest'),

            LinkMeta::make()
                ->rel('mask-icon')
                ->attr('color', '#e5392a')
                ->href('/safari-pinned-tab.svg'),

            Meta::make()
                ->name('theme-color')
                ->content('#e5392a'),

            Meta::make()
                ->name('msapplication-TileColor')
                ->content('#e5392a'),

            OpenGraph::make()
                ->property('title')
                ->content('Home'),

            OpenGraph::make()
                ->property('site_name')
                ->content(config('app.name')),

            OpenGraph::make()
                ->property('locale')
                ->content(app()->getLocale()),

            Twitter::make()
                ->name('card')
                ->content('summary_large_image'),

            Twitter::make()
                ->name('creator')
                ->content('@log1x'),

            Twitter::make()
                ->name('image')
                ->content(asset('/social.png')),
        ]);

        return $next($request);
    }
}
