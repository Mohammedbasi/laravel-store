<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class Nav extends Component
{
    public $items;


    public function __construct($context = 'side')
    {
        $this->items = $this->prepareItems(config('nav'));
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.nav');
    }

    protected function prepareItems($items)
    {
        $user = Auth::user();
        foreach ($items as $key => $item) {
            if (isset($item['ability']) && !$user->can($item['ability'])) {
                unset($items[$key]);
            }
        }
        return $items;
    }
}
