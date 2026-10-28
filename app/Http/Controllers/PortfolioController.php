<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Tag;
use App\Support\StructuredData;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function index(Request $request): View
    {
        $projects = Project::with('tags')->get();
        $tags = Tag::withCount('projects')->get()->where('projects_count', '>', 0);

        // ?tag=video renders the list already filtered, so the filter links work without JS too.
        $active = $tags->contains('slug', $request->query('tag')) ? $request->query('tag') : 'all';

        $filters = ['all' => [__('portfolio.all'), $projects->count()]];
        foreach ($tags as $tag) {
            $filters[$tag->slug] = [$tag->name, $tag->projects_count];
        }

        return view('portfolio.index', [
            'content' => page('portfolio-page'),
            'projects' => $projects,
            'filters' => $filters,
            'active' => $active,
        ]);
    }

    public function show(Project $project): View
    {
        $project->load('tags');
        $tagIds = $project->tags->modelKeys();

        // Projects that share a service with this one come first.
        $others = Project::with('tags')->whereKeyNot($project->getKey())->get()
            ->sortByDesc(fn (Project $other) => count(array_intersect($other->tags->modelKeys(), $tagIds)))
            ->take(3);

        return view('portfolio.show', [
            'project' => $project,
            'content' => $project,
            'listing' => page('portfolio-page'),
            'others' => $others,
            'schema' => [
                StructuredData::project($project),
                StructuredData::breadcrumbs([
                    __('common.nav.home') => route('home'),
                    __('common.nav.portfolio') => route('portfolio.index'),
                    $project->title => route('portfolio.show', $project),
                ]),
            ],
        ]);
    }
}
