<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;

class MetaComposer
{
    public function compose(View $view)
    {
        if(request()->segment(5) != '')
        {
            $metaTitle = ucfirst(str_replace('-','', request()->segment(5))).' - '.config('app.name');
        }
        else if(request()->segment(4) != '')
        {
            $metaTitle = ucfirst(str_replace('-','', request()->segment(4))).' - '.config('app.name');
        }
        else if(request()->segment(3) != '')
        {
            $metaTitle = ucfirst(str_replace('-','', request()->segment(3))).' - '.config('app.name');
        }
        else if(request()->segment(2) != '')
        {
            $metaTitle = ucfirst(str_replace('-','', request()->segment(2))).' - '.config('app.name');
        }
        else if(request()->segment(1) != '')
        {
            $metaTitle = ucfirst(str_replace('-','', request()->segment(1))).' - '.config('app.name');
        }

        if(isset($metaTitle))
        {
            $view->with('metaTitle', $metaTitle);
        }
    }
}


