<?php

namespace App\Repositories;

use App\Attachment;
use App\Attachment_link;
use App\Attribute_Scheme_Type;
use App\History;
use App\ObjectType;
use App\PreWork;
use App\PreworkReport;
use App\PreWorkReportParticipants;
use App\User;
use Auth;
use File;
use DB;
use Illuminate\Support\Facades\Mail;

class PreWorkRepository extends Repository
{
    protected $arr_attr = [];
    protected $result_mail = '';

    public function __construct(PreWork $pre_work) {
        $this->model  = $pre_work;

    }

    public function addPreWork($request) {


         /*  if (\Gate::denies('create',$this->model)) {
                 abort(403);
             }*/

        if (Auth::check()) {

            $user = Auth::user()->id;
        }else{
            abort(403);
        }


            $data = $request->all();



            $prework = PreWork::create([

                'name' => $data['name_prework'],
                'type_id' => $data['object_id'],
                'description' => $data['desc_prework'],
                'author_id' => $data['responsible'],



            ]);


        $user = User::find($data['responsible']);


        Mail::send('admin.mail_responsible', ['author' => $user, 'id' => $prework->id ,'title' => $prework->name], function ($message) use ($user) {

            $message->from('reamonn2008@mail.ru', 'Сервис-портал');
            $message->to($user->email)->subject('Назначен ответственный');

        });




        if($request->file('doc_prework')) {

               $size = $request->file('doc_prework')->getSize();
               $img_name = $request->file('doc_prework')->getClientOriginalName();
               $path = $request->file('doc_prework')->store('uploads', 'public');


               $attach = Attachment::create([
                   'path' => $path,
                   'filename' => $img_name,
                   'size' => $size
               ]);

               Attachment_link::create([
                   'attachment_id' => $attach->id,
                   'object_id' => $prework->id,
                   'object_type_id' => 1
               ]);
           }

           /*добавление статуса */

        $status =  DB::table('custom_attribute_value')->insert(
                ['attr_id' => 5, 'object_id' => $prework->id, 'object_type_id' => $data['object_id'] , 'value' => 1]
            );

            $res = $this->sortAttr($data,$prework);


            return ['status' => 'Работа добавлена'];
        }



    public function sortAttr($data,$prework)

    {

        if(isset($data['attr_simple']))
        {
         foreach ($data['attr_simple'] as $id => $item)
             {
                    foreach ($item as $key => $val){
                      DB::table($key)->insert(
                         ['attr_id' => $id, 'object_id' => $prework->id ,'object_type_id' => $data['object_id'] ,'value' => $val]
                     );
                    }
             }
        }
        if(isset($data['attr_custom']))
        {
            foreach ($data['attr_custom'] as $id => $item)
                {
                    foreach ($item as $key => $values){

                     foreach ($values as $v_key => $val) {

                         DB::table('custom_attribute_value')->insert(
                             ['attr_id' => $id, 'object_id' => $prework->id, 'object_type_id' => $data['object_id'] , 'value' => $v_key]
                         );
                        }
                    }
                }
        }


    }


    public function getAttr($preWork)
    {
        $classname = mb_strtolower((new \ReflectionClass($preWork))->getShortName());

        $object = ObjectType::where('name',$classname)->first();
        $attrs = Attribute_Scheme_Type::where('type_id',$object->id)->get();


        foreach ($attrs as $attr)
        {
            $this->arr_attr[] = $attr->attr_id;
        }



        return $this->arr_attr;


    }



    public function updatePreWork($request) {



        $name_attr ='';
        $data = $request->all();

        if(isset($data['responsible'])) {
            $pre_work = DB::table('prework')->where('id', $data['pre_work_id'])->update(['description' => $data['desc'],'author_id'=> $data['responsible']]);
            $author = User::find($data['responsible']);

            $history = History::create([
                'event_comment' => 'Изменение ответственного на('.$author->name.')',
                'author_id' => $user = Auth::user()->id,
                'object_type_id' => 1,
                'object_id' => $data['pre_work_id'],
                'add_object_id' => $data['responsible']
            ]);


            $pre_work = PreWork::find($data['pre_work_id']);
            $emails = User::all();
            $users = [];
            foreach ($emails as $email){

                $users[] = $email->email;

            }


            $result = Mail::send('admin.mail_update_responsible',['author' => $author, 'id' => $data['pre_work_id'], 'prework' => $pre_work ,'users' => $users],function ($message) use ($users){

              $message->from('reamonn2008@mail.ru','Сервис-портал');
              $message->to($users)->subject('Изменение ответственного');

            });

        }




       if(isset($data['attr'])){



           $sql = DB::table('custom_attribute_value');
           foreach ($data['attr'] as $key =>  $attr)
           {

                $sql->where('attr_id',$key)->where('object_id',$data['pre_work_id'])->update([
                    'value' => $attr

                ]);


                if($key == 4){
                    $name_attr = 'источник';
                    $attr = DB::table('source')->where('id',$attr)->first();
                    $history = History::create([
                        'event_comment' => 'Изменение атрибута '.$name_attr.'  на('.$attr->name.')',
                        'author_id' => $user = Auth::user()->id,
                        'object_type_id' => 1,
                        'object_id' => $data['pre_work_id'],
                        'add_object_id' => $key
                    ]);
                }
                if($key == 2){
                   $name_attr = 'клиент';
                    $attr = DB::table('client')->where('id',$attr)->first();

                    $history = History::create([
                        'event_comment' => 'Изменение атрибута '.$name_attr.'  на('.$attr->name.')',
                        'author_id' => $user = Auth::user()->id,
                        'object_type_id' => 1,
                        'object_id' => $data['pre_work_id'],
                        'add_object_id' => $key
                    ]);
                }
                if($key == 3){
                   $name_attr = 'Вид работ';
                    $attr = DB::table('prework_type')->where('id',$attr)->first();

                    $history = History::create([
                        'event_comment' => 'Изменение атрибута '.$name_attr.'  на('.$attr->name.')',
                        'author_id' => $user = Auth::user()->id,
                        'object_type_id' => 1,
                        'object_id' => $data['pre_work_id'],
                        'add_object_id' => $key
                    ]);

                }

                if($key == 5){
                       $name_attr = 'статус';
                        $attr = DB::table('status')->where('id',$attr)->first();


                    $history = History::create([
                        'event_comment' => 'Изменение атрибута '.$name_attr.'  на('.$attr->name.')',
                        'author_id' => $user = Auth::user()->id,
                        'object_type_id' => 1,
                        'object_id' => $data['pre_work_id'],
                        'add_object_id' => $key
                    ]);


                }






           }



       }

        if(isset($data['float_attr'])){

            $sql2 = DB::table('float_attribute_values');

            foreach ($data['float_attr'] as $key => $attr)
            {
                $sql2->where('attr_id',$key)->where('object_id',$data['pre_work_id'])->update([
                    'value' => $attr

                ]);

                if($key == 1){
                    $name_attr = 'бюджет';
                    $attr = DB::table('float_attribute_values')->where('attr_id',$key)->where('value',$attr)->first();

                    $history = History::create([
                        'event_comment' => 'Изменение атрибута '.$name_attr.'  на('.$attr->value.')',
                        'author_id' => $user = Auth::user()->id,
                        'object_type_id' => 1,
                        'object_id' => $data['pre_work_id'],
                        'add_object_id' => $key
                    ]);
                }

            }


        }

        if(isset($data['int_attr'])){

            $sql2 = DB::table('int_attribute_values');

            foreach ($data['int_attr'] as $key => $attr)
            {
                $sql2->where('attr_id',$key)->where('object_id',$data['pre_work_id'])->update([
                    'value' => $attr

                ]);

                if($key == 6){
                    $name_attr = 'оценка выполненной работы';
                    $attr = DB::table('int_attribute_values')->where('attr_id',$key)->where('value',$attr)->first();

                    $history = History::create([
                        'event_comment' => 'Изменение атрибута '.$name_attr.'  на('.$attr->value.')',
                        'author_id' => $user = Auth::user()->id,
                        'object_type_id' => 1,
                        'object_id' => $data['pre_work_id'],
                        'add_object_id' => $key
                    ]);


                }




            }



        }

        if($request->file('file_pre_work')) {

            $size = $request->file('file_pre_work')->getSize();
            $img_name = $request->file('file_pre_work')->getClientOriginalName();
            $path = $request->file('file_pre_work')->store('uploads', 'public');


            $attach = Attachment::create([
                'path' => $path,
                'filename' => $img_name,
                'size' => $size
            ]);

           $attach_link = Attachment_link::create([
                'attachment_id' => $attach->id,
                'object_id' => $data['pre_work_id'],
                'object_type_id' => 1
            ]);


            $history = History::create([
                'event_comment' => 'Добавление документа',
                'author_id' => $user = Auth::user()->id,
                'object_type_id' => 1,
                'object_id' => $data['pre_work_id'],
                'add_object_id' => $attach_link->id
            ]);

        }

        $emails = [];

        $pre_work = PreWork::find($data['pre_work_id']);

        if($pre_work->author_id === Auth::user()->id) {

            return ['status' => 'Работа изменена'];

        }else{

            $users = User::all();


            foreach ($users as $user){
                $emails[] = $user->email;
            }


            Mail::send('admin.mail', ['author' => Auth::user()->name, 'id' => $data['pre_work_id'] ,'pre_work' => $pre_work], function ($message) use ($emails) {

                $message->from('reamonn2008@mail.ru', 'Сервис-портал');
                $message->to($emails)->subject('Редактирование работы');

            });

        }





        return ['status' => 'Работа изменена'];

    }

    public function deletePreWork($id) {

  /*      if (Gate::denies('edit',$this->model)) {
            abort(403);
        }*/


      $attach_link = Attachment_link::where('object_id',$id)->where('object_type_id',1)->get();

      if($attach_link){
            foreach ($attach_link as $link)
            {
                $link->attachment()->delete();
                $link->delete();
            }
        }


        $custom_attr = DB::table('custom_attribute_value')->where('object_id',$id)->delete();
        $custom_float = DB::table('float_attribute_values')->where('object_id',$id)->delete();
        $custom_int = DB::table('int_attribute_values')->where('object_id',$id)->delete();
        $custom_string = DB::table('string_attribute_value')->where('object_id',$id)->delete();


        $prework_report = PreworkReport::where('work_id',$id)->get();

        if($prework_report){
            foreach ($prework_report as $report) {
                $report->commentsPreWorkReport()->delete();


            }

            foreach ($prework_report as $value)
            {
                $attach_link = Attachment_link::where('object_id',$value->id)->where('object_type_id',9)->get();

                if($attach_link){
                    foreach ($attach_link as $link)
                    {
                        $link->attachment()->delete();
                        $link->delete();
                    }
                }

            }

            foreach ($prework_report as $report)
            {
                PreWorkReportParticipants::where('id',$report->id)->delete();
            }
            $prework_report = PreworkReport::where('work_id',$id)->delete();

        }



        $prework = PreWork::where('id',$id)->get();
        foreach ($prework as $value)
        {
            $value->commentsPreWork()->delete();
            $value->delete();
        }

            return ['status' => 'Работа удалена'];

    }




}

?>
