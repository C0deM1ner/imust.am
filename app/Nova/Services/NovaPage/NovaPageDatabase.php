<?php

namespace App\Nova\Services\NovaPage;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Whitecube\NovaPage\Pages\Template;
use Whitecube\NovaPage\Sources\SourceInterface;

class NovaPageDatabase implements SourceInterface
{
    /**
     * The table used to store static pages content
     *
     * @var string
     */
    protected $table;

    /**
     * The model used to store static pages content
     */
    protected string $model;

    /**
     * The fetched model instance
     *
     * @var Model
     */
    protected $original;

    /**
     * Retrieve the source's name
     */
    public function getName(): string
    {
        return 'database';
    }

    /**
     * Set the source's configuration parameters
     */
    public function setConfig(array $config): void
    {
        $this->table = $config['table_name'];
        $this->model = $config['model'];
    }

    /**
     * Retrieve data from the database
     *
     * @return array|void
     */
    public function fetch(Template $template)
    {
        $model = $this->getOriginal($template);

        if (! $model->id) {
            return;
        }

        $attributes = $this->getParsedAttributes(
            $template,
            $model->attributes ? json_decode($model->attributes, true) : []
        );

        return [
            'title' => $model->title,
            'meta_title' => $model->meta_title,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at,
            'attributes' => $attributes,
        ];
    }

    /**
     * Save template in the database
     */
    public function store(Template $template): void
    {
        $original = $this->getOriginal($template);
        $original->fill([
            'name' => $template->getName(),
            'title' => $template->getAttributeValue('title'),
            'is_indexable' => $template->getAttributeValue('is_indexable'),
            'meta_title' => $template->getAttributeValue('meta_title'),
            'meta_description' => $template->getAttributeValue('meta_description'),
            'meta_keywords' => $template->getAttributeValue('meta_keywords'),
            'meta_image' => $template->getAttributeValue('meta_image'),
            'type' => $template->getType(),
            'attributes' => json_encode($template->getAttributes()),
            'created_at' => $template->getDate('created_at'),
            'updated_at' => Carbon::now(),
        ]);

        $original->save();
    }

    /**
     * Retrieve original StaticPage model
     *
     * @return null|Model
     */
    public function getOriginal(Template $template)
    {
        if (! $this->original) {
            $instance = call_user_func($this->model.'::where', 'name', $template->getName())->first();

            $this->original = $instance ?? (new $this->model);
        }

        return $this->original;
    }

    /**
     * Retrieve and parse attributes array
     *
     * @param  array  $attributes
     */
    protected function getParsedAttributes(Template $template, $attributes): array
    {
        foreach ($attributes as $key => $value) {
            if (! is_array($value) && ! is_object($value)) {
                continue;
            }
            if ($template->isJsonAttribute($key)) {
                continue;
            }
            $attributes[$key] = json_encode($value);
        }

        return $attributes;
    }

    /**
     * Get the text to display in the missing value exception
     */
    public function getErrorLocation($type, $name): string
    {
        return $this->getName().' table "'.$this->table.'". Page "'.$name.'".';
    }
}
