<?php

namespace App\Repositories;

use App\Attachment;
use App\Attachment_link;
use App\Attribute_Scheme_Type;
use App\ObjectType;
use App\PreWork;
use App\PreworkReport;
use App\PreWorkReportParticipants;
use Auth;
use File;
use DB;
use App\History;

class PreWorkReportRepository extends Repository
{
    protected $arr_attr = [];


    public function __construct(PreworkReport $pre_work_rep) {
        $this->model  = $pre_work_rep;

    }

    public function addPreWorkRep($request) {


        /*  if (\Gate::denies('create',$this->model)) {
                abort(403);
            }*/

        if (Auth::check()) {

            $user = Auth::user()->id;
        }else{
            abort(403);
        }
        $data =  $request->all();


     $prework_rep = PreworkReport::create([

            'name' => $data['pre_work_report_name'],
            'number' => '1',
            'total_hours' => (int)$data['pre_work_report_hours'],
            'total_minute' => 0,
            'budget' => $data['pre_work_report_name_budget'],
            'description' => $data['desc_report'],
            'work_id' => $data['pre_work_rep_id'],
            'author_id' => $user,
            'start_time' => date('d.m.Y'),
            'end_time' => $data['pre_work_report_name_date'],
            'type_id' => 9,



        ]);


        if(isset($data['participants']) && $data['participants'] != '' )
        {

            $sql= DB::table('prework_report_participants');

            foreach ($data['participants']['fio'] as $key => $item){


                 $sql->insert([
                            'name' => $data['participants']['fio'][$key],
                            'contacts' => $data['participants']['contacts'][$key],
                            'position' => $data['participants']['position'][$key],
                            'is_agent' => $data['participants']['is_agent'][$key],
                            'prework_report_id' => $prework_rep->id,
                            'created_at' => date('Y-m-d h:m:s'),
                            'updated_at' => date('Y-m-d h:m:s')
                        ]);
            }

        }



        if($request->file('pre_work_file_report')) {

            $size = $request->file('pre_work_file_report')->getSize();
            $img_name = $request->file('pre_work_file_report')->getClientOriginalName();
            $path = $request->file('pre_work_file_report')->store('uploads', 'public');


            $attach = Attachment::create([
                'path' => $path,
                'filename' => $img_name,
                'size' => $size
            ]);

            Attachment_link::create([
                'attachment_id' => $attach->id,
                'object_id' => $prework_rep->id,
                'object_type_id' => 9
            ]);
        }



        return ['status' => 'Отчет добавлен'];
    }




    public function updatePreWorkRep($request) {


        /*     if (\Gate::denies('edit',$this->model)) {
                 abort(403);
             }*/

        $data = $request->all();





       $pre_work_rep = DB::table('prework_report')->where('id',$data['pre_work_report_id'])->update([


            'name'=> $data['name_report'],
            'number'=> '1',
            'start_time'=> $data['start_time'],
            'end_time'=> $data['end_time'],
            'total_hours'=> $data['total_hours'],
            'budget'=> $data['budget'],
            'description'=> $data['description'],



        ]);



        if(isset($data['participants']) && $data['participants'] != '' )
        {

            foreach ($data['participants']['fio'] as $key => $item){


                $sql= DB::table('prework_report_participants')->where('id',$key)->update([
                    'name' => $data['participants']['fio'][$key],
                    'contacts' => $data['participants']['contacts'][$key],
                    'position' => $data['participants']['position'][$key],
                    'is_agent' => $data['participants']['is_agent'][$key],


                ]);
            }

        }


        if($request->file('file_report')) {

            $size = $request->file('file_report')->getSize();
            $img_name = $request->file('file_report')->getClientOriginalName();
            $path = $request->file('file_report')->store('uploads', 'public');


            $attach = Attachment::create([
                'path' => $path,
                'filename' => $img_name,
                'size' => $size
            ]);

            $attach_link =   Attachment_link::create([
                'attachment_id' => $attach->id,
                'object_id' => $data['pre_work_report_id'],
                'object_type_id' => 9
            ]);

            $history = History::create([
                'event_comment' => 'Добавление документа',
                'author_id' => $user = Auth::user()->id,
                'object_type_id' => 9,
                'object_id' => $data['pre_work_report_id'],
                'add_object_id' => $attach_link->id
            ]);
        }




        return ['status' => 'Отчет изменен'];

    }

    public function deletePreWorkRep($user) {

        if (Gate::denies('edit',$this->model)) {
            abort(403);
        }


        $user->roles()->detach();

        if($user->delete()) {
            return ['status' => 'Отчет удален'];
        }
    }




}

?>
