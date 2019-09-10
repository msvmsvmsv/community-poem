<?php

namespace Display\Http\Controllers;

use Display\Repositories\Spaces;
use Illuminate\Http\Request;
use Display\Repositories\Responses;

class SpaceSlideshowController
{
    public function __construct(Spaces $spaces, Responses $responses)
    {
        $this->spaces = $spaces;
        $this->responses = $responses;
    }

    public function show(Request $req)
    {
        $space = $this->spaces->matchingSlug(
            $req->route('space')
        );

        return view('spaceSlideshow', [
            'space' => $space,
            'responses' => $this->responses->approved($space),
            'autoplay' => 'true',
        ]);
    }
}