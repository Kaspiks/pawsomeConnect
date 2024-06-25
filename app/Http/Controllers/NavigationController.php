<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Structs\MenuItem;

class NavigationController extends Controller
{
    public static function getMenuItems()
    {
        $menuItems = [
            new MenuItem('Home', '/home'),
            new MenuItem('About', '/about'),
            new MenuItem('Contact', '/contact'),
        ];

        return $menuItems;
    }
}
