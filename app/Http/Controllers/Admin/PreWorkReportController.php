<?php

namespace App\Http\Controllers\Admin;

use App\Attachment_link;
use App\Http\Controllers\Controller;
use App\Http\Requests\PreWorkReportRequest;
use App\PreWorkReportParticipants;
use Illuminate\Http\Request;
use App\Repositories\PreWorkReportRepository;
use App\PreWorkReport;
use App\History;

class PreWorkReportController extends AdminController
{
    //

    protected $pre_rep;



    public function __construct( PreWorkReportRepository $pre_rep) {
        parent::__construct();

        /*   if (Gate::denies('EDIT_USERS')) {
                   abort(403);
               }*/

        $this->pre_rep = $pre_rep;


        $this->template = 'admin.pre_work_rep';

    }

    public function all($id)
    {

        $pre_work_rep = PreWorkReport::where('work_id',$id)->get();


        $this->content = view('admin.pre_work_all_reports')->with(['pre_works_rep' => $pre_work_rep , 'pre_works_rep_id' => $id])->render();

        return $this->renderOutput();

    }

    public function create($id)
    {
        //


        $this->content = view('admin.pre_work_report_create')->with(['pre_work_rep_id' => $id])->render();

        return $this->renderOutput();



    }

    public function store(PreWorkReportRequest $request)
    {

        $data = $request->all();


        $result = $this->pre_rep->addPreWorkRep($request);
        if(is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }
        return redirect('admin/prework-reports/'.$data['pre_work_rep_id'])->with($result);

    }

    public function show($id)
    {

        $report = PreWorkReport::find($id);

        $participants = PreWorkReportParticipants::where('prework_report_id',$report->id)->get();

        $attachments = Attachment_link::where('object_id',$report->id)->where('object_type_id',9)->get();

        $history = History::where('object_id',$id)->where('object_type_id',9)->get();

        $com = $report->commentsPreWorkReport->where('object_type_id',9)->groupBy('parent_id');
        $count = count($report->commentsPreWorkReport->where('object_type_id',9));



        $this->content = view('admin.pre_work_report_show')->with([
            'report' => $report,
            'participants' => $participants ,
            'attachments' => $attachments,
            'history' => $history,
            'com' => $com,
            'count' => $count

        ])->render();

        return $this->renderOutput();
    }


    public function edit($id)
    {

        $report = PreWorkReport::find($id);

        $participants = PreWorkReportParticipants::where('prework_report_id',$report->id)->get();

        $attachments = Attachment_link::where('object_id',$report->id)->where('object_type_id',9)->get();

        $this->content = view('admin.pre_work_report_edit')->with(['report' => $report, 'participants' => $participants ,'attachments' => $attachments,'pre_work_report_id' => $id])->render();

        return $this->renderOutput();
    }


    public function update(Request $request)
    {

        $data = $request->all();


        $result = $this->pre_rep->updatePreWorkRep($request);
        if(is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }
        return redirect('admin/prework-report-show/'.$data['pre_work_report_id'])->with($result);


    }










}
