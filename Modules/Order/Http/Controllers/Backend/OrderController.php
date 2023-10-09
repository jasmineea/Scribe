<?php

namespace Modules\Order\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Order\Entities\MasterFiles;
use Modules\Comment\Http\Requests\Backend\CommentsRequest;
use Modules\Comment\Notifications\NewCommentAdded;
use Spatie\Activitylog\Models\Activity;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Backend\BackendBaseController;
use Session;

class OrderController extends Controller
{
    use Authorizable;

    public $module_title;

    public $module_name;

    public $module_path;

    public $module_icon;

    public $module_model;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'Campaigns';

        // module name
        $this->module_name = 'orders';

        // directory path of the module
        $this->module_path = 'order::backend';

        // module icon
        $this->module_icon = 'fas fa-orders';

        // module model name, path
        $this->module_model = "Modules\Order\Entities\Order";
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';
        $user_id=$request->query('id');
        $s_id=$request->query('s_id');
        $type=$request->query('type');
        $$module_name = $module_model::paginate();

        Log::info(label_case($module_title.' '.$module_action).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return view(
            "order::backend.$module_name.index_datatable",
            compact('module_title', 'module_name', "$module_name", 'module_icon', 'module_name_singular', 'module_action', 'user_id','type','s_id')
        );
    }

    public function masterfiles(Request $request){
        
        $module_title = 'Master Print Files';
        $module_name = 'master_files';
        $module_icon = $this->module_icon;
        $module_model = 'Modules\Order\Entities\MasterFiles';
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';
        $$module_name = $module_model::paginate();

        Log::info(label_case($module_title.' '.$module_action).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return view(
            "order::backend.$module_name.index_datatable",
            compact('module_title', 'module_name', "$module_name", 'module_icon', 'module_name_singular', 'module_action')
        );
    }

    public function master_files_data(Request $request)
    {

        $module_title = 'Master Print Files';
        $module_name = 'master_files';
        $module_icon = $this->module_icon;
        $module_model = 'Modules\Order\Entities\MasterFiles';
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        $type=$request->query('type');

        $$module_name = $module_model::select('id', 'uploaded_recipient_file', 'post_uploaded_recipient_file','downloaded_times','downloaded_at','total_records', 'created_at');

        $data = $$module_name;

        return Datatables::of($$module_name)

                        ->addColumn('uploaded_recipient_file', function ($data) {
                            return  '<a href="'.env('APP_URL').'/admin/orders/downloadAction/'.$data->uploaded_recipient_file.'/'.$data->id.'">'.$data->uploaded_recipient_file.'</a>';
                        })
                        ->addColumn('post_uploaded_recipient_file', function ($data) {
                            return  '<a href="'.env('APP_URL').'/admin/orders/downloadAction/'.$data->post_uploaded_recipient_file.'/'.$data->id.'">'.$data->post_uploaded_recipient_file.'</a><form enctype="multipart/form-data" method="post" action="'.route('frontend.cards.uploadPreBccFile').'"><input type="file" onchange="form.submit()" name="upload_post_file" ><input type="hidden" name="_token" value="'.csrf_token().'" /><input type="hidden" name="master_id" value="'.$data->id.'"></form>';
                        })
                        ->addColumn('downloaded_times', function ($data) {
                            return  $data->downloaded_times." times";
                        })
                        ->editColumn('created_at', function ($data) {
                            $module_name = $this->module_name;

                            $diff = Carbon::now()->diffInHours($data->created_at);

                            if ($diff < 25) {
                                return $data->created_at->diffForHumans();
                            } else {
                                return $data->created_at->isoFormat('LLLL');
                            }
                        })
                        ->addColumn('action', function ($data) {
                            $master_file_record_limit = setting('master_file_record_limit');
                            return  $master_file_record_limit<$data->total_records?"<a href='/admin/orders/dividefile/".$data->id."'>Divide</a>":"-";
                        })
                        ->rawColumns(['uploaded_recipient_file','post_uploaded_recipient_file','action'])
                        ->orderColumns(['id'], '-:column $1')
                        ->make(true);
    }

    public function index_data(Request $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        $user_id=$request->query('user_id');
        $type=$request->query('type');
        $s_id=$request->query('s_id');

        $$module_name = $module_model::select('id', 'user_id','campaign_name','campaign_type', 'campaign_message', 'order_amount', 'final_printing_file', 'status', 'updated_at','listing_id');
        if ($user_id) {
            $$module_name=$$module_name->where('user_id', $user_id);
        }
        if ($type=='published') {
            $$module_name=$$module_name->whereIn('status',['pending','processing','printing','shipped','delivered'])->where('campaign_type','one-time');
        }
        if ($type=='draft') {
            $$module_name=$$module_name->whereIn('status',['pending','payment-pending','draft','on-going','paused'])->whereIn('campaign_type',['on-going']);
        }
        if ($s_id) {
            $$module_name=$$module_name->whereIn('status',['pending','payment-pending','draft','on-going','paused'])->where('id',$s_id);
        }
        $data = $$module_name;

        return Datatables::of($$module_name)
                        ->addColumn('total_recipient', function ($data) {
                            $return_string =  isset($data->listing)?$data->listing->contacts->count():0;
                            return $return_string;
                        })
                        ->addColumn('message_overview', function ($data) {
                            if(@$data->campaign_message&&file_exists(public_path('img/preview/'.@$data->campaign_message))){ $preview_image=asset('img/preview/'.@$data->campaign_message); return "<img width='100px' class='model_preview'  style='display:inline;cursor: zoom-in;' data-url='".$preview_image."' src='".$preview_image."'>"; }else{
                                return $data->campaign_message;
                            }
                        })
                        ->addColumn('download_print_file', function ($data) {
                            if($data->final_printing_file){
                                $preview=asset('files/'.$data->final_printing_file);
                                $return='<a class="anchor_class" href="'.$preview.'">Download File</a></td>';
                            }else{
                                $return='<a class="anchor_class" href="'.route('frontend.cards.generateFiles',$data->id).'/1">Generate File</a>';
                            }
                            return  $return;
                        })
                        ->editColumn('user_id', function ($data) {
                            $return_string = '<strong>'.$data->user->name.'</strong>';
                            return $return_string;
                        })
                        ->editColumn('status', function ($data) {
                            $status_list=status_list();
                            $select_html="<select class='change_status' data-id='".$data->id."'>";
                            foreach ($status_list as $key => $value) {
                                $selected=$data->status==$key?'selected':'';
                                $select_html.="<option value='".$key."' ".$selected.">".$value."</option>";
                            }
                            $select_html.="</select>";
                            return $select_html;
                        })
                        ->editColumn('updated_at', function ($data) {
                            $module_name = $this->module_name;

                            $diff = Carbon::now()->diffInHours($data->updated_at);

                            if ($diff < 25) {
                                return $data->updated_at->diffForHumans();
                            } else {
                                return $data->updated_at->isoFormat('LLLL');
                            }
                        })
                        ->rawColumns(['name', 'action','user_id','download_print_file','status','message_overview'])
                        ->orderColumns(['id'], '-:column $1')
                        ->make(true);
    }
    public function downloadAction(Request $request, $filename,$master_id) {
        $master_file=MasterFiles::find($master_id);
        $master_file->downloaded_times =$master_file->downloaded_times + 1;
        $master_file->downloaded_at=now();
        $master_file->save();
        return Storage::disk('public')->download($filename);
    }
    public function changeStatus(Request $request,$order_id,$status) {
        $module_model = $this->module_model;
        $order=$module_model::find($order_id);
        $order->status =$status;
        $order->save();
        Session::flash('success', 'Status changed successfully.');
        return redirect()->route('backend.orders.index',['type'=>'published']);
    }
    public function dividefile(Request $request,$id) {
        $master_file=MasterFiles::find($id);
        $master_file_record_limit = setting('master_file_record_limit');

        $final_message=[];
        $i=0;
        $order_json=read_excel_data($master_file->uploaded_recipient_file, 1);
        foreach ($order_json['data'] as $key_1 => $value_1) {
            $final_message[$i]['order_date']=$value_1['Campaign Date'];
            $final_message[$i]['order_id']=$value_1['Campaign ID'];
            $final_message[$i]['order_name']=$value_1['Campaign Name'];
            $final_message[$i]['order_owner']=$value_1['Campaign Order'];
            $final_message[$i]['order_status']=$value_1['Campaign Status'];
            $final_message[$i]['first_name']=$value_1['Recipient First Name'];
            $final_message[$i]['last_name']=$value_1['Recipient Last Name'];
            $final_message[$i]['email']=$value_1['Recipient Email'];
            $final_message[$i]['company_name']=$value_1['Recipient Company'];
            $final_message[$i]['phone']=$value_1['Recipient Phone'];
            $final_message[$i]['address']=$value_1['Recipient Address'];
            $final_message[$i]['city']=$value_1['Recipient City'];
            $final_message[$i]['state']=$value_1['Recipient State'];
            $final_message[$i]['zip']=$value_1['Recipient Zip'];
            $final_message[$i]['final_message']=$value_1['Custom Message'];

            if(count($final_message)>=$master_file_record_limit){
                $return_file_name=create_excel_for_master_file($final_message);
                MasterFiles::create([
                    'uploaded_recipient_file' => trim($return_file_name['file_name']),
                    'total_records' => count($final_message)
                ]);
                $final_message = [];
            }
            $i=$i+1;
        }

        if($final_message){
            $return_file_name=create_excel_for_master_file($final_message);
            MasterFiles::create([
                'uploaded_recipient_file' => trim($return_file_name['file_name']),
                'total_records' => count($final_message)
            ]);
        }
        $master_file->delete();
        Session::flash('success', 'Master File divided successfully.');
        return redirect()->route('backend.orders.masterfiles');
    }

}
