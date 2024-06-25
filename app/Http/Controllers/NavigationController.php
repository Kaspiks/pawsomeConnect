<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Structs\MenuItem;

class NavigationController extends Controller
{
    public static function getMenuItems()
    {
        $menuItems = [
            new MenuItem('Posts', '/posts'),
            new MenuItem('Events', '/events'),
            new MenuItem('Services', '/services'),
        ];

        return $menuItems;
    }
}
