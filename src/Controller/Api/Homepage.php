<?php

namespace App\Controller\Api;


class Homepage
{
    public function home()
    {
        return [
            'success' =>true,
            'message' =>'Api accessible',
        ];
    }
}