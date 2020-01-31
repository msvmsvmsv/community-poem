<?php

namespace CommunityPoem\Nova;

use CommunityPoem\Nova\Actions\RetreiveMissingResponses;
use CommunityPoem\Repositories\Themes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Timothyasp\Color\Color;

class Space extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'CommunityPoem\Space';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name', 'typeform_id', 'slug',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(Request $request)
    {
        $keys = collect(resolve(Themes::class)->all())->keys();

        $keys = $keys->mapWithKeys(function ($item) {
            return [$item => $item];
        });

        return [
            Text::make('Name'),
            Text::make('Admin Emails'),
            Text::make('Typeform Id'),
            Text::make('List Domain')->help('Domain to automatically launch the response list. Do not include propocol or forward slashes (e.g. https://).'),
            Text::make('Admin Url', function () {
                $url = URL::signedRoute(
                    'approveResponses',
                    [
                        'space' => $this->resource->slug,
                    ]
                );

                return sprintf('<a href="%s" target="_blank" class="no-underline dim text-primary font-bold">Moderation Screen</a>', $url);
            })->asHtml(),
            Text::make('Slug'),
            Color::make('Primary Color'),
            Color::make('Secondary Color'),
            Code::make('Embed Code')->language('html'),
            Select::make('Theme')->options($keys),
            HasMany::make('Responses'),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @return array
     */
    public function actions(Request $request)
    {
        return [resolve(RetreiveMissingResponses::class)];
    }
}
