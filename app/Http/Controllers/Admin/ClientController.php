<?php

namespace App\Http\Controllers\Admin;

use App\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class ClientController extends AdminController
{


    public function __construct()

    {


        parent::__construct();


        $this->template = 'admin.client';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

        $clients = Client::orderBy('id','desc')->paginate(15);


        $this->content = view('admin.clients_all')->with(['clients' => $clients])->render();

        return $this->renderOutput();

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->content = view('admin.client_create')->render();

        return $this->renderOutput();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $messages = [
            'name.required' => 'Не заполнено название',
            'code1c.required' => 'Не заполнен код 1с',
            'short_name.required' => 'Не заполнено краткое название'
        ];

        $request->validate([
            'name' => 'required',
            'code1c' => 'required',
            'short_name' => 'required'
        ],$messages);


        Client::create($request->all());

        return redirect()->route('clients.index')->with('success','Клиент добавлен');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function search(Request $request)

    {
        $data =  $request->all();

        $clients = Client::where('name', 'like', $data['search'].'%')->orderBy('id','desc')->paginate(15);



        $this->content = view('admin.clients_all')->with(['clients' => $clients])->render();

        return $this->renderOutput();



    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        $this->content = view('admin.client_edit')->with(['client' => $client])->render();

        return $this->renderOutput();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        //

        $messages = [
            'name.required' => 'Не заполнено название',
            'code1c.required' => 'Не заполнен код 1с',
            'short_name.required' => 'Не заполнено краткое название'
        ];


        $request->validate([
            'name' => 'required',
            'code1c' => 'required',
            'short_name' => 'required'
        ],$messages);

        $client->update($request->all());

        return redirect()->route('clients.index')
            ->with('success', 'Клиент обновлен!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {

        $client->delete();

        return redirect()->route('clients.index')
            ->with('success', 'Клиент удален!');
    }
}
