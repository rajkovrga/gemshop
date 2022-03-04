<?php

namespace GemShopAPI\App\Controllers;

use GemShopAPI\App\Core\Routing\PutMethod;
use GemShopAPI\App\Core\Routing\RouteGroup;

#[RouteGroup('/user', [])]
class UserController
{
    #[PutMethod('/update')]
    public function update()
    {

    }

}