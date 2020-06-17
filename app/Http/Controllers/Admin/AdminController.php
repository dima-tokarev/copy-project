<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use function Sodium\add;
use Illuminate\Support\Arr;

class AdminController extends Controller
{
    //
    protected $user;
    protected $template;
    protected $content = false;
    protected $title;
    protected $vars;

    public function __construct()
    {
        $this->user = Auth::user();
        if(!$this->user){

        }
    }

    public function renderOutput(){
        $this->vars = Arr::add($this->vars,'title',$this->title);
        $navigation = view('admin.navigation')->render();

        $this->vars = Arr::add($this->vars,'navigation',$navigation);
        if($this->content){
            $this->vars = Arr::add($this->vars,'content',$this->content);
        }

        $footer = view('admin.footer')->render();
        $this->vars = Arr::add($this->vars,'footer',$footer);

        return view($this->template)->with($this->vars);
    }



}
