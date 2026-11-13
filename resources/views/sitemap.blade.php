{{-- Printed with echo: a literal XML declaration would be read as a PHP open tag. --}}
{!! '<' . '?xml version="1.0" encoding="UTF-8"?>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach (['home', 'about', 'portfolio.index', 'services', 'contact', 'privacy'] as $route)
        <url>
            <loc>{{ route($route) }}</loc>
        </url>
    @endforeach
    @foreach ($projects as $project)
        <url>
            <loc>{{ route('portfolio.show', $project->slug) }}</loc>
            @if ($project->updated_at)
                <lastmod>{{ $project->updated_at->toAtomString() }}</lastmod>
            @endif
        </url>
    @endforeach
</urlset>
