<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\PreWork;
use App\PreworkReport;
use Illuminate\Http\Request;
use Validator;
use App\Comments;
use Illuminate\Support\Facades\Auth;
use App\History;
use App\User;
use Illuminate\Support\Facades\Mail;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $data = $request->except('_token','comment_pre_work_id','comment_parent');
        $data['name'] = $user->name;
        $data['email'] = $user->email;
        $data['object_id'] = $request->input('comment_pre_work_id');
        $data['parent_id'] = $request->input('comment_parent');
        $data['object_type_id'] = $request->input('object_type_id');

        $messages = [
            'text.required' => 'Не заполнено поле текст',

        ];



        $validator = Validator::make($data,[

            'object_id' => 'integer:required',
            'object_type_id' => 'integer:required',
            'parent_id' => 'integer:required',
            'text' => 'string|required'

        ],$messages);


        $validator->sometimes(['name','email'],'required|max:255',function($input) {

            return !Auth::check();

        });

        if($validator->fails()) {
            return \Response::json(['error'=>$validator->errors()->all()]);
        }



        $comment = new Comments($data);

        if($user) {
            $comment->author_id = $user->id;
        }

        $prework = PreWork::find($data['object_id']);

        $prework->commentsPreWork()->save($comment);


        $emails = [];


        if($prework->author_id === Auth::user()->id) {

            /*false*/

        }else{

            $users = User::all();


            foreach ($users as $user){
                $emails[] = $user->email;
            }


            Mail::send('admin.mail_comment', ['author' => Auth::user()->name, 'id' => $prework->id,'pre_work' => $prework], function ($message) use ($emails) {

                $message->from('reamonn2008@mail.ru', 'Сервис-портал');
                $message->to($emails)->subject('Добавление комментария к работе');

            });

        }




        if($comment)
        {
            $history = History::create([
                'event_comment' => 'Добавление комментария',
                'author_id' => $user = Auth::user()->id,
                'object_type_id' => $request->input('object_type_id'),
                'object_id' => $prework->id,
                'add_object_id' => $comment->id
            ]);
        }



        $data['id'] = $comment->id;
        $data['hash'] = md5($data['email']);

        $view_comment = view('admin.content_one_comment')->with('data' , $data)->render();

        return \Response::json(['success' => true,'comment' => $view_comment,'data' => $data]);

        exit();
    }


    public function storeReport(Request $request)
    {


        $user = Auth::user();

        $data = $request->except('_token','comment_pre_work_id','comment_parent');
        $data['name'] = $user->name;
        $data['email'] = $user->email;
        $data['object_id'] = $request->input('comment_pre_work_id');
        $data['parent_id'] = $request->input('comment_parent');
        $data['object_type_id'] = $request->input('object_type_id');

        $messages = [
            'text.required' => 'Не заполнено поле текст',

        ];



        $validator = Validator::make($data,[

            'object_id' => 'integer:required',
            'object_type_id' => 'integer:required',
            'parent_id' => 'integer:required',
            'text' => 'string|required'

        ],$messages);


        $validator->sometimes(['name','email'],'required|max:255',function($input) {

            return !Auth::check();

        });

        if($validator->fails()) {
            return \Response::json(['error'=>$validator->errors()->all()]);
        }



        $comment = new Comments($data);

        if($user) {
            $comment->author_id = $user->id;
        }

        $report = PreworkReport::find($data['object_id']);

        $report->commentsPreWorkReport()->save($comment);


        if($comment)
        {
            $history = History::create([
                'event_comment' => 'Добавление комментария',
                'author_id' => $user = Auth::user()->id,
                'object_type_id' => $request->input('object_type_id'),
                'object_id' => $report->id,
                'add_object_id' => $comment->id
            ]);
        }



        $data['id'] = $comment->id;
        $data['hash'] = md5($data['email']);

        $view_comment = view('admin.content_one_comment')->with('data' , $data)->render();

        return \Response::json(['success' => true,'comment' => $view_comment,'data' => $data]);

        exit();
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
