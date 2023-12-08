<?php

namespace Modules\Customer\Http\Controllers\Backend;

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
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use App\Models\User;
use App\Events\Frontend\WalletRecharge;
use Session;

class CustomerController extends BackendBaseController
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
        $this->module_title = 'Customers';

        // module name
        $this->module_name = 'customers';

        // directory path of the module
        $this->module_path = 'customer::backend';

        // module icon
        $this->module_icon = 'fas fa-list';

        // module model name, path
        $this->module_model = "App\Models\User";
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        $$module_name = $module_model::paginate();

        Log::info(label_case($module_title.' '.$module_action).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return view(
            "customer::backend.$module_name.index_datatable",
            compact('module_title', 'module_name', "$module_name", 'module_icon', 'module_name_singular', 'module_action')
        );
    }

    public function index_data()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        $ids = \DB::table('model_has_roles')->pluck('model_id');

        $$module_name = $module_model::select('id', 'name', 'email', 'mobile','exclude_mf', 'gender', 'date_of_birth', 'wallet_balance', 'updated_at')->whereNotIn('id', $ids);

        $data = $$module_name;

        return Datatables::of($$module_name)
                        ->addColumn('action', function ($data) {
                            $module_name = $this->module_name;

                            return view("customer::backend.$module_name.includes.customers_actions", compact('module_name', 'data'));
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
                        ->editColumn('date_of_birth', function ($data) {
                            return $data->date_of_birth?$data->date_of_birth->isoFormat('d MMM Y'):"-";
                        })
                        ->editColumn('exclude_mf', function ($data) {
                            $checked=$data->exclude_mf?"checked='checked'":"";
                            return "<input type='checkbox' ".$checked." class='checkbox_for_exclude' data-id='".$data->id."'>";
                        })
                        ->rawColumns(['name', 'action','exclude_mf'])
                        ->orderColumns(['id'], '-:column $1')
                        ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function details($id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        $$module_name_singular = $module_model::findOrFail($id);
        if(empty($$module_name_singular->api_access_token)){
            $$module_name_singular->api_access_token=$$module_name_singular->createToken('Laravelia')->accessToken;
            $$module_name_singular->save();
        }
        

        Log::info(label_case($module_title.' '.$module_action).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return view(
            "customer::backend.$module_name.details_datatable",
            compact('module_title', 'module_name', 'module_icon', 'module_name_singular', 'module_action', "$module_name_singular", 'id')
        );
    }
    public function wallet_recharge(Request $request){
        if($request->action_type=='dr'){
            $user = User::find($request->user_id);

            $transaction = new Transaction;
            $transaction->user_id = $request->user_id;
            $transaction->amount = $request->recharge_amount;
            $transaction->wallet_balance = $user->wallet_balance-$request->recharge_amount;
            $transaction->status = 1;
            $transaction->currency_amount = 0;
            $transaction->payment_method = '';
            $transaction->type = 'Dr';
            $transaction->comment = 'Amount Deducted From Wallet By Admin';
            $transaction->transaction_json =json_encode([]);
            $transaction->online_transaction_id =0;
            $transaction->save();

            $user = User::find($request->user_id);
            $user->wallet_balance = $transaction->wallet_balance;
            $user->save();
        }
        if($request->action_type=='cr'){
            $user = User::find($request->user_id);

            $transaction = new Transaction;
            $transaction->user_id = $request->user_id;
            $transaction->amount = $request->recharge_amount;
            $transaction->wallet_balance = $user->wallet_balance+$request->recharge_amount;
            $transaction->status = 1;
            $transaction->currency_amount = 0;
            $transaction->payment_method = '';
            $transaction->type = 'Cr';
            $transaction->comment = 'Wallet Recharge By Admin';
            $transaction->transaction_json =json_encode([]);
            $transaction->online_transaction_id =0;
            $transaction->save();

            $user = User::find($request->user_id);
            $user->wallet_balance = $transaction->wallet_balance;
            $user->save();
            event(new WalletRecharge($user, $transaction));
        }
        Session::flash('success', 'wallet updated successfully.');

        return redirect("admin/customers");
    }
}
