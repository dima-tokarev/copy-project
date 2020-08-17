<?php

namespace App\Repositories;

use App\Attachment;
use App\Attachment_link;
use App\Attribute_Scheme_Type;
use App\Custom_Type;
use App\History;
use App\Http\Requests\Request;
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
                'user_id' => Auth::user()->id



            ]);


       if(isset($data['responsible']) && $data['responsible'] != '') {
           $user = User::find($data['responsible']);


/*           Mail::send('admin.mail_responsible', ['author' => $user, 'id' => $prework->id, 'title' => $prework->name], function ($message) use ($user) {

               $message->from('reamonn2008@mail.ru', 'Сервис-портал');
               $message->to($user->email)->subject('Назначен ответственный');

           });*/
       }

        /* Участники сторон */

        if(isset($data['participants']) && $data['participants'] != '' )
        {

            $sql= DB::table('prework_report_participants');

            foreach ($data['participants']['fio'] as $key => $item){


                $sql->insert([
                    'name' => $data['participants']['fio'][$key],
                    'contacts' => $data['participants']['contacts'][$key],
                    'position' => $data['participants']['position'][$key],
                    'is_agent' => $data['participants']['is_agent'][$key],
                    'prework_id' => $prework->id,
                    'created_at' => date('Y-m-d h:m:s'),
                    'updated_at' => date('Y-m-d h:m:s')
                ]);
            }

        }




        if($request->file('file_pre_work')) {

            foreach ($data['file_pre_work'] as $file) {
                $size = $file->getSize();
                $img_name = $file->getClientOriginalName();
                $path = $file->store('uploads', 'public');


                $attach = Attachment::create([
                    'path' => $path,
                    'filename' => $img_name,
                    'size' => $size
                ]);

                $attach_link = Attachment_link::create([
                    'attachment_id' => $attach->id,
                    'object_id' => $prework->id,
                    'object_type_id' => 1
                ]);


            }
        }

           /*добавление статуса */

  /*      $status =  DB::table('custom_attribute_value')->insert(
                ['attr_id' => 5, 'object_id' => $prework->id, 'object_type_id' => $data['object_id'] , 'value' => 1]
            );*/

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

                    if($val) {
                        DB::table($key)->insert(
                            ['attr_id' => $id, 'object_id' => $prework->id, 'object_type_id' => $data['object_id'], 'value' => $val]
                        );
                    }else{
                        DB::table($key)->insert(
                            ['attr_id' => $id, 'object_id' => $prework->id, 'object_type_id' => $data['object_id'], 'value' => null]
                        );
                    }
                    }
             }
        }
        if(isset($data['attr_custom']))
        {

            foreach ($data['attr_custom'] as $id => $item)
                {

                    foreach ($item as $key => $values){

                    if($values) {

                            $val_custom = DB::table($key)->where('name',$values)->first();


                            DB::table('custom_attribute_value')->insert(
                                ['attr_id' => $id, 'object_id' => $prework->id, 'object_type_id' => $data['object_id'], 'value' => $val_custom->id]
                            );

                    }else{
                        DB::table('custom_attribute_value')->insert(
                            ['attr_id' => $id, 'object_id' => $prework->id, 'object_type_id' => $data['object_id'], 'value' => null]
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
        $attrs = Attribute_Scheme_Type::where('type_id',$object->id)->orderBy('position')->get();



        return $attrs;


    }



    public function updatePreWork($request) {



        $name_attr ='';
        $data = $request->all();

        $pre_work = PreWork::find($data['pre_work_id']);


        if(isset($data['responsible'])) {

            $q = DB::table('prework')->where('id', $data['pre_work_id'])->first();

            if($q->author_id != $data['responsible'] && !isset($data['agreement'])) {

                $pre_work = DB::table('prework')->where('id', $data['pre_work_id'])->update(['author_id' => $data['responsible']]);
                $old_author = User::find($q->author_id);
                $author = User::find($data['responsible']);

            if(isset($history)) {
                $history->historyEvent()->create([
                    'event_comment' => 'Изменение ответственного c ' . $old_author->name . ' на(' . $author->name . ')',
                    'history_id' => $history->id
                ]);
            }else{
                $history = History::create([

                    'object_type_id' => 1,
                    'author_id' => Auth::user()->id,
                    'object_id' => $data['pre_work_id'],


                ]);

                $history->historyEvent()->create([
                    'event_comment' => 'Изменение ответственного c ' . $old_author->name . ' на(' . $author->name . ')',
                    'history_id' => $history->id
                ]);
            }






                $result = Mail::send('admin.mail_update_responsible',['author' => $author, 'id' => $data['pre_work_id'], 'prework' => PreWork::find($data['pre_work_id']) ,'author' => $author,'old_name' => $old_author],function ($message) use ($author){

                  $message->from('reamonn2008@mail.ru','Сервис-портал');
                  $message->to($author->email)->subject('Изменение ответственного');

                });
            }

        }

      /* if isset agreement */

        if(isset($data['agreement'])) {
            $q = DB::table('prework')->where('id', $data['pre_work_id'])->first();

            $history = History::create([

                'object_type_id' => 1,
                'author_id' => Auth::user()->id,
                'object_id' => $data['pre_work_id'],


            ]);


            /* user leader*/

            $users = User::all();
            $leader = '';
            foreach ($users as $user){
                if($user->roles->first()->name == 'Руководитель'){
                    $leader = $user;
                    break;
                }
            }




            $pre_work = DB::table('prework')->where('id', $data['pre_work_id'])->update(['author_id' => $leader->id]);

            /* user lider*/
            $old_author = User::find($q->author_id);

            $history->historyEvent()->create([
                'event_comment' => 'Изменение ответственного c ' . $old_author->name . ' на(' . $leader->name . ')',
                'history_id' => $history->id
            ]);




            $q = Custom_Type::where('attr_id',5)->where('object_id',$data['pre_work_id'])->first();


                    $sql = Custom_Type::where('attr_id', 5)->where('object_id', $data['pre_work_id'])->update([
                        'value' => 3

                    ]);


                        $name_attr = 'Статус';
                        $old_attr = DB::table('status')->where('id', $q->value)->first();

                        if ($old_attr == null) {
                            $old_attr = '';
                        } else {
                            $old_attr = $old_attr->name;
                        }


                        if (isset($history)) {
                            $history->historyEvent()->create([
                                'event_comment' => 'Изменение атрибута ' . $name_attr . ' c ( ' . $old_attr . ' ) на ( К согласованию )',
                                'history_id' => $history->id
                            ]);
                        }







            /* отсылаем лидеру*/

            $result = Mail::send('admin.mail_update_responsible',['id' => $data['pre_work_id'], 'prework' => PreWork::find($data['pre_work_id']) ,'author' => $leader,'old_name' => $old_author],function ($message) use ($leader){

                $message->from('reamonn2008@mail.ru','Сервис-портал');
                $message->to($leader->email)->subject('Изменение ответственного');

            });



        }
        /* end if isset agreement */


        /* update desc */
      if(isset($data['desc'])) {
          $pre =  PreWork::find($data['pre_work_id']);

          if (Auth::user()->id === $pre->user_id) {

              $q = DB::table('prework')->where('id', $data['pre_work_id'])->first();

              if ($q->description != trim($data['desc'])) {
                  $pre_work = DB::table('prework')->where('id', $data['pre_work_id'])->update(['description' => $data['desc']]);



                  if(isset($history)) {
                      $history->historyEvent()->create([
                          'event_comment' => 'Изменено описание на (' . $data['desc'] . ')',
                          'history_id' => $history->id
                      ]);
                  }else{
                      $history = History::create([

                          'object_type_id' => 1,
                          'author_id' => Auth::user()->id,
                          'object_id' => $data['pre_work_id'],

                      ]);

                      $history->historyEvent()->create([
                          'event_comment' => 'Изменено описание на (' . $data['desc'] . ')',
                          'history_id' => $history->id
                      ]);

                  }



              }
          }
      }


       if(isset($data['attr'])){




           foreach ($data['attr'] as $key =>  $attr)
           {



               $q = Custom_Type::where('attr_id',$key)->where('object_id',$data['pre_work_id'])->first();

               if($q->value != $attr) {
                   $sql = Custom_Type::where('attr_id', $key)->where('object_id', $data['pre_work_id'])->update([
                       'value' => $attr

                   ]);




                   if ($key == 4 ) {


                          $name_attr = 'источник';
                          $old_attr = DB::table('source')->where('id', $q->value)->first();
                          $attr2 = DB::table('source')->where('id', $attr)->first();

                          if ($old_attr == null) {
                              $old_attr = '';
                          } else {
                              $old_attr = $old_attr->name;
                          }


                          if (isset($history)) {
                              $history->historyEvent()->create([
                                  'event_comment' => 'Изменение атрибута ' . $name_attr . ' c ( ' . $old_attr . ' ) на(' . $attr2->name . ')',
                                  'history_id' => $history->id
                              ]);
                          } else {
                              $history = History::create([

                                  'object_type_id' => 1,
                                  'author_id' => Auth::user()->id,
                                  'object_id' => $data['pre_work_id'],


                              ]);

                              $history->historyEvent()->create([
                                  'event_comment' => 'Изменение атрибута ' . $name_attr . ' c ( ' . $old_attr . ' ) на(' . $attr2->name . ')',
                                  'history_id' => $history->id
                              ]);
                          }





                   }
                   if ($key == 2) {
                       $name_attr = 'клиент';
                       $old_attr = DB::table('client')->where('id', $q->value)->first();
                       $attr2 = DB::table('client')->where('id', $attr)->first();

                       if($old_attr == null)
                       {
                           $old_attr = '';
                       }else{
                           $old_attr = $old_attr->name;
                       }


                       if(isset($history)) {
                           $history->historyEvent()->create([
                               'event_comment' => 'Изменение атрибута '.$name_attr.' c ( ' . $old_attr . ' ) на (' . $attr2->name  . ')',
                               'history_id' => $history->id
                           ]);
                       }else{
                           $history = History::create([

                               'object_type_id' => 1,
                               'author_id' => Auth::user()->id,
                               'object_id' => $data['pre_work_id'],


                           ]);

                           $history->historyEvent()->create([
                               'event_comment' => 'Изменение атрибута '.$name_attr.' c ( ' . $old_attr . ' ) на (' . $attr2->name  . ')',
                               'history_id' => $history->id
                           ]);
                       }
                   }
                   if ($key == 3) {
                       $name_attr = 'Вид работ';
                       $old_attr = DB::table('prework_type')->where('id', $q->value)->first();
                       $attr2 = DB::table('prework_type')->where('id', $attr)->first();


                       if($old_attr == null)
                       {
                           $old_attr = '';
                       }else{
                           $old_attr = $old_attr->name;
                       }


                       if(isset($history)) {
                           $history->historyEvent()->create([
                               'event_comment' => 'Изменение атрибута '.$name_attr.' c ( ' . $old_attr . ' ) на (' . $attr2->name  . ')',
                               'history_id' => $history->id
                           ]);
                       }else{
                           $history = History::create([

                               'object_type_id' => 1,
                               'author_id' => Auth::user()->id,
                               'object_id' => $data['pre_work_id'],


                           ]);

                           $history->historyEvent()->create([
                               'event_comment' => 'Изменение атрибута '.$name_attr.' c ( ' . $old_attr . ' ) на (' . $attr2->name  . ')',
                               'history_id' => $history->id
                           ]);
                       }


                   }

                   if ($key == 5 && !isset($data['agreement'])) {



                            $name_attr = 'статус';

                            $old_attr = DB::table('status')->where('id', $q->value)->first();
                            $attr2 = DB::table('status')->where('id', $attr)->first();

                            if ($old_attr == null) {
                                $old_attr = '';
                            } else {
                                $old_attr = $old_attr->name;
                            }


                            if (isset($history)) {
                                $history->historyEvent()->create([
                                    'event_comment' => 'Изменение атрибута ' . $name_attr . ' c ( ' . $old_attr . ' ) на (' . $attr2->name . ')',
                                    'history_id' => $history->id
                                ]);
                            } else {
                                $history = History::create([

                                    'object_type_id' => 1,
                                    'author_id' => Auth::user()->id,
                                    'object_id' => $data['pre_work_id'],


                                ]);

                                $history->historyEvent()->create([
                                    'event_comment' => 'Изменение атрибута ' . $name_attr . ' c ( ' . $old_attr . ' ) на (' . $attr2->name . ')',
                                    'history_id' => $history->id
                                ]);
                            }


                   }
               }





           }



       }

        if(isset($data['float_attr'])){


            foreach ($data['float_attr'] as $key => $attr)
            {
                $q = DB::table('float_attribute_values')->where('attr_id',$key)->where('object_id',$data['pre_work_id'])->first();

                if($q->value != $attr) {

                    DB::table('float_attribute_values')->where('attr_id', $key)->where('object_id', $data['pre_work_id'])->update([
                        'value' => $attr

                    ]);

                    if ($key == 1) {
                        $name_attr = 'бюджет';
                        $attr2 = DB::table('float_attribute_values')->where('attr_id', $key)->where('value', $attr)->first();



                        if(isset($history)) {
                            $history->historyEvent()->create([
                                'event_comment' => 'Изменение атрибута '.$name_attr.' c ( ' . $q->value . ' ) на (' . $attr2->value  . ')',
                                'history_id' => $history->id
                            ]);
                        }else{
                            $history = History::create([

                                'object_type_id' => 1,
                                'author_id' => Auth::user()->id,
                                'object_id' => $data['pre_work_id'],


                            ]);

                            $history->historyEvent()->create([
                                'event_comment' => 'Изменение атрибута '.$name_attr.' c ( ' . $q->value . ') на (' . $attr2->value  . ')',
                                'history_id' => $history->id
                            ]);
                        }



                    }

                    if ($key == 8) {
                        $name_attr = 'Фактический бюджет';
                        $attr2 = DB::table('float_attribute_values')->where('attr_id', $key)->where('value', $attr)->first();



                        if(isset($history)) {
                            $history->historyEvent()->create([
                                'event_comment' => 'Изменение атрибута '.$name_attr.' c ( ' . $q->value . ' ) на (' . $attr2->value  . ')',
                                'history_id' => $history->id
                            ]);
                        }else{
                            $history = History::create([

                                'object_type_id' => 1,
                                'author_id' => Auth::user()->id,
                                'object_id' => $data['pre_work_id'],


                            ]);

                            $history->historyEvent()->create([
                                'event_comment' => 'Изменение атрибута '.$name_attr.' c ( ' . $q->value . ' ) на (' . $attr2->value  . ')',
                                'history_id' => $history->id
                            ]);
                        }
                    }

                }

            }


        }

        if(isset($data['int_attr'])){



            foreach ($data['int_attr'] as $key => $attr)
            {

                $q = DB::table('int_attribute_values')->where('attr_id',$key)->where('object_id',$data['pre_work_id'])->first();
             if($q->value != $attr) {
                 DB::table('int_attribute_values')->where('attr_id', $key)->where('object_id', $data['pre_work_id'])->update([
                     'value' => $attr

                 ]);

                 if ($key == 6) {
                     $name_attr = 'оценка работы';
                     $attr2 = DB::table('int_attribute_values')->where('attr_id', $key)->where('value', $attr)->first();


                     if(isset($history)) {
                         $history->historyEvent()->create([
                             'event_comment' => 'Изменение атрибута '.$name_attr.' c ( ' . $q->value . ' ) на (' . $attr2->value  . ')',
                             'history_id' => $history->id
                         ]);
                     }else{
                         $history = History::create([

                             'object_type_id' => 1,
                             'author_id' => Auth::user()->id,
                             'object_id' => $data['pre_work_id'],


                         ]);

                         $history->historyEvent()->create([
                             'event_comment' => 'Изменение атрибута '.$name_attr.' c ( ' . $q->value . ' ) на (' . $attr2->value  . ')',
                             'history_id' => $history->id
                         ]);
                     }


                 }

                 if ($key == 11) {
                     $name_attr = 'Количество часов';


                     $attr2 = DB::table('int_attribute_values')->where('attr_id', $key)->where('value', $attr)->first();


                     if(isset($history)) {
                         $history->historyEvent()->create([
                             'event_comment' => 'Изменение атрибута '.$name_attr.' c ( ' . $q->value . ' ) на (' . $attr2->value  . ')',
                             'history_id' => $history->id
                         ]);
                     }else{
                         $history = History::create([

                             'object_type_id' => 1,
                             'author_id' => Auth::user()->id,
                             'object_id' => $data['pre_work_id'],


                         ]);

                         $history->historyEvent()->create([
                             'event_comment' => 'Изменение атрибута '.$name_attr.' c ( ' . $q->value . ' ) на (' . $attr2->value  . ')',
                             'history_id' => $history->id
                         ]);
                     }


                 }

             }


            }



        }

        if(isset($data['string_attr'])){



            foreach ($data['string_attr'] as $key => $attr)
            {



                $q = DB::table('string_attribute_value')->where('attr_id',$key)->where('object_id',$data['pre_work_id'])->first();
                if($q->value != $attr) {
                    DB::table('string_attribute_value')->where('attr_id', $key)->where('object_id', $data['pre_work_id'])->update([
                        'value' => $attr

                    ]);

                    if ($key == 9) {
                        $name_attr = 'начата';
                        $attr_q = DB::table('string_attribute_value')->where('attr_id', $key)->where('value', $attr)->first();


                        if(isset($history)) {
                            $history->historyEvent()->create([
                                'event_comment' => 'Изменение атрибута '.$name_attr.' c ( ' . $q->value . ' ) на (' . date("d-m-Y", strtotime($attr))  . ')',
                                'history_id' => $history->id
                            ]);
                        }else{
                            $history = History::create([

                                'object_type_id' => 1,
                                'author_id' => Auth::user()->id,
                                'object_id' => $data['pre_work_id'],


                            ]);

                            $history->historyEvent()->create([
                                'event_comment' => 'Изменение атрибута '.$name_attr.' c ( ' . $q->value . ' ) на (' . date("d-m-Y", strtotime($attr))  . ')',
                                'history_id' => $history->id
                            ]);
                        }


                    }

                    if ($key == 10) {
                        $name_attr = 'Дата выполнения';
                        $attr_q = DB::table('string_attribute_value')->where('attr_id', $key)->where('value', $attr)->first();


                        if(isset($history)) {
                            $history->historyEvent()->create([
                                'event_comment' => 'Изменение атрибута '.$name_attr.' c ( ' . $q->value . ' ) на (' . date("d-m-Y", strtotime($attr))  . ')',
                                'history_id' => $history->id
                            ]);
                        }else{
                            $history = History::create([

                                'object_type_id' => 1,
                                'author_id' => Auth::user()->id,
                                'object_id' => $data['pre_work_id'],


                            ]);

                            $history->historyEvent()->create([
                                'event_comment' => 'Изменение атрибута '.$name_attr.' c ( ' . $q->value . ' ) на(' . date("d-m-Y", strtotime($attr))  . ')',
                                'history_id' => $history->id
                            ]);
                        }

                    }


                }

            }



        }

          if(isset($data['comment']) && $data['comment'] != '' ) {



              if(isset($history)) {
                  $history->historyComment()->create([
                      'comment' => $data['comment'],
                      'author' => Auth::user()->id,
                      'history_id' => $history->id
                  ]);
              }else{
                  $history = History::create([

                      'object_type_id' => 1,
                      'author_id' => Auth::user()->id,
                      'object_id' => $data['pre_work_id'],

                  ]);

                  $history->historyComment()->create([
                      'comment' => $data['comment'],
                      'author' => Auth::user()->id,
                      'history_id' => $history->id
                  ]);

              }





                 $emails = [];

                  $users = User::all();


                  foreach ($users as $user){
                      $emails[] = $user->email;
                  }


                  Mail::send('admin.mail_comment', ['author' => Auth::user()->name, 'id' => $data['pre_work_id'],'pre_work' => PreWork::find($data['pre_work_id'])], function ($message) use ($emails) {

                      $message->from('reamonn2008@mail.ru', 'Сервис-портал');
                      $message->to($emails)->subject('Добавление комментария к работе');

                  });



          }


        if(isset($data['participants']) && $data['participants'] != '' )
        {


            foreach ($data['participants']['fio'] as $key => $item){

                    if(PreWorkReportParticipants::find($key)) {
                        $sql = DB::table('prework_report_participants')->where('id', $key)->update([
                            'name' => $data['participants']['fio'][$key],
                            'contacts' => $data['participants']['contacts'][$key],
                            'position' => $data['participants']['position'][$key],
                            'is_agent' => $data['participants']['is_agent'][$key],
                        ]);
                    }else {
                        $sql = PreWorkReportParticipants::create([
                            'name' => $data['participants']['fio'][$key],
                            'contacts' => $data['participants']['contacts'][$key],
                            'position' => $data['participants']['position'][$key],
                            'is_agent' => $data['participants']['is_agent'][$key],
                            'prework_id' => $data['pre_work_id'],
                        ]);
                    }

            }

        }


        if($request->file('file_pre_work')) {

         foreach ($data['file_pre_work'] as $file) {
             $size = $file->getSize();
             $img_name = $file->getClientOriginalName();
             $path = $file->store('uploads', 'public');


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


             if(isset($history)) {
                 $history->historyEvent()->create([
                     'event_comment' => 'Добавление документа (' . $img_name . ')',
                     'history_id' => $history->id,

                 ]);
             }else{
                 $history = History::create([

                     'object_type_id' => 1,
                     'author_id' => Auth::user()->id,
                     'object_id' => $data['pre_work_id'],

                 ]);

                 $history->historyEvent()->create([
                     'event_comment' => 'Добавление документа (' . $img_name . ')',
                     'history_id' => $history->id,

                 ]);

             }



         }
        }

        $emails = [];

        $pre_work = PreWork::find($data['pre_work_id']);

        if($pre_work->author_id === Auth::user()->id) {

            return ['status' => 'Работа изменена'];

        }else{

    /*        $users = User::all();


            foreach ($users as $user){
                $emails[] = $user->email;
            }


            Mail::send('admin.mail', ['author' => Auth::user()->name, 'id' => $data['pre_work_id'] ,'pre_work' => $pre_work], function ($message) use ($emails) {

                $message->from('reamonn2008@mail.ru', 'Сервис-портал');
                $message->to($emails)->subject('Редактирование работы');

            });*/

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

/*
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



        }*/



        $preworks = PreWork::where('id',$id)->get();


        foreach ($preworks as $value)
        {
            $value->commentsPreWork()->delete();

            PreWorkReportParticipants::where('prework_id', $value->id)->delete();

            $value->delete();
        }





            return ['status' => 'Работа удалена'];

    }




}

?>
