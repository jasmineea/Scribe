<?php

namespace Modules\Transaction\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Comment\Http\Requests\Backend\CommentsRequest;
use Modules\Comment\Notifications\NewCommentAdded;
use Spatie\Activitylog\Models\Activity;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Backend\BackendBaseController;

class TransactionController extends Controller
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
        $this->module_title = 'Wallet Transactions';

        // module name
        $this->module_name = 'transactions';

        // directory path of the module
        $this->module_path = 'transaction::backend';

        // module icon
        $this->module_icon = 'fas fa-transactions';

        // module model name, path
        $this->module_model = "Modules\Transaction\Entities\Transaction";
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

        $$module_name = $module_model::paginate();

        $user_id=$request->query('id');

        Log::info(label_case($module_title.' '.$module_action).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return view(
            "transaction::backend.$module_name.index_datatable",
            compact('module_title', 'module_name', "$module_name", 'module_icon', 'module_name_singular', 'module_action', 'user_id')
        );
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
        $$module_name = $module_model::select('id', 'user_id', 'amount', 'currency_amount', 'wallet_balance', 'type', 'updated_at', 'comment');
        if ($user_id) {
            $$module_name=$$module_name->where('user_id', $user_id);
        }

        $data = $$module_name;

        return Datatables::of($$module_name)
                        ->addColumn('total_recipient', function ($data) {
                            $order_json=json_decode($data->order_json, true);
                            $return_string =  isset($order_json['step_5']['total_recipient'])?$order_json['step_5']['total_recipient']:'';
                            ;
                            return $return_string;
                        })
                        ->editColumn('user_id', function ($data) {
                            $return_string = '<strong>'.$data->user->name.'</strong>';
                            return $return_string;
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
                        ->rawColumns(['name', 'action','user_id'])
                        ->orderColumns(['id'], '-:column $1')
                        ->make(true);
    }
}
