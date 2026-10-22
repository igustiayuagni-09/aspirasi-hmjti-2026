<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class PanelAdminUtama extends Component
{
    /**
     * Pastikan return type adalah View (Kapital)
     */
    public function render(): View
    {
        return view('layouts.admin-new');
    }
}