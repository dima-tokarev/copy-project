<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends AdminController
{
    //
    public function __construct()
    {

        parent::__construct();
        $this->template = 'admin.index';

    }

    public function index()
    {
        $this->title = 'Панель администратора';
        return $this->renderOutput();

    }
}
