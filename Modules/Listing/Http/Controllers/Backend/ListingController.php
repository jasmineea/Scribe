<?php

namespace Modules\Listing\Http\Controllers\Backend;

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

class ListingController extends Controller
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
        $this->module_title = 'Recipients';

        // module name
        $this->module_name = 'listings';

        // directory path of the module
        $this->module_path = 'listing::backend';

        // module icon
        $this->module_icon = 'fas fa-list';

        // module model name, path
        $this->module_model = "Modules\Listing\Entities\Listing";
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
        $s_id=$request->query('s_id');


        Log::info(label_case($module_title.' '.$module_action).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return view(
            "listing::backend.$module_name.index_datatable",
            compact('module_title', 'module_name', "$module_name", 'module_icon', 'module_name_singular', 'module_action', 'user_id','s_id')
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
        $s_id=$request->query('s_id');

        $$module_name = $module_model::select('id', 'user_id', 'name', 'status', 'updated_at');
        if ($user_id) {
            $$module_name=$$module_name->where('user_id', $user_id);
        }
        if ($s_id) {
            $$module_name=$$module_name->where('id',$s_id);
        }
        $data = $$module_name;

        return Datatables::of($$module_name)
                        ->addColumn('action', function ($data) {
                            $module_name = $this->module_name;

                            return view('backend.includes.action_column_1', compact('module_name', 'data'));
                        })
                        ->editColumn('user_id', function ($data) {
                            $return_string = '<strong>'.$data->user->name.'</strong>';
                            return $return_string;
                        })
                        ->addColumn('contact_count', function ($data) {
                            $return_string = '<strong>'.$data->contacts->count().'</strong>';
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
                        ->rawColumns(['name', 'action','user_id','contact_count'])
                        ->orderColumns(['id'], '-:column $1')
                        ->make(true);
    }

    public function contacts_data($id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        $$module_name_singular = $module_model::findOrFail($id);

        $contacts = $$module_name_singular->contacts()->select('contacts.id', 'first_name', 'last_name', 'company_name', 'email', 'phone', 'address', 'city', 'state', 'zip', 'contacts.updated_at');

        $data = $contacts;

        return Datatables::of($contacts)
                        ->addColumn('action', function ($data) {
                            $module_name = $this->module_name;

                            return view('backend.includes.action_column', compact('module_name', 'data'));
                        })
                        ->addColumn('address', function ($data) {
                            return $data->address.",".$data->city.",".$data->state.",".$data->zip;
                        })
                        ->addColumn('name', function ($data) {
                            return $data->first_name." ".$data->last_name;
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
                        ->rawColumns(['first_name','last_name', 'action'])
                        ->orderColumns(['users.id'], '-:column $1')
                        ->make(true);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Contacts';

        $$module_name_singular = $module_model::findOrFail($id);

        $contacts = $$module_name_singular->contacts()->latest()->paginate();

        $activities = Activity::where('subject_type', '=', $module_model)
                                ->where('log_name', '=', $module_name)
                                ->where('subject_id', '=', $id)
                                ->latest()
                                ->paginate();

        Log::info(label_case($module_title.' '.$module_action).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return view(
            "listing::backend.$module_name.show",
            compact('module_title', 'module_name', 'module_icon', 'module_name_singular', 'module_action', "$module_name_singular", 'activities', 'contacts')
        );
    }
}
