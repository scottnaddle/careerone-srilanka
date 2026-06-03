<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PeerReviewContentResponseForm extends Component
{
    public $content;
    public $questionList;
    public $peerItem;
    /**
     * Create a new component instance.
     */
    public function __construct($content, $questionList, $peerItem)
    {
        $this->content = $content;
        $this->questionList = $questionList;
        $this->peerItem = $peerItem;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.peer-review-content-response-form');
    }
}
