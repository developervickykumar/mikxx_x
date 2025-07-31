<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class BusinessPermission extends Component
{
    /**
     * The permission to check.
     */
    public string $permission;

    /**
     * The context for permission check.
     */
    public array $context;

    /**
     * Create a new component instance.
     */
    public function __construct(string $permission, array $context = [])
    {
        $this->permission = $permission;
        $this->context = $context;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|string
    {
        return view('components.business-permission');
    }

    /**
     * Check if the current user has the required permission.
     */
    public function hasPermission(): bool
    {
        return auth()->user()?->hasPermission($this->permission, $this->context) ?? false;
    }
} 