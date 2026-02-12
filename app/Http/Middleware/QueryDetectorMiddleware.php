<?php

namespace App\Http\Middleware;

use Closure;
use BeyondCode\QueryDetector\QueryDetector;

class QueryDetectorMiddleware
{
    protected $detector;

    public function __construct(QueryDetector $detector)
    {
        $this->detector = $detector;
    }

    public function handle($request, Closure $next)
    {
        // Enable only for specific routes
        if ($request->is('admin/*') || $request->is('posts*')) {
            config(['querydetector.enabled' => true]);
        }

        $response = $next($request);

        // Add query statistics to response headers
        if (config('querydetector.enabled')) {
            $queries = $this->detector->getQueries();
            $response->headers->set('X-Query-Count', count($queries));
            $response->headers->set('X-Duplicate-Queries', $this->getDuplicateCount($queries));
        }

        return $response;
    }

    protected function getDuplicateCount($queries)
    {
        $queryStrings = array_column($queries, 'query');
        return count($queryStrings) - count(array_unique($queryStrings));
    }
}