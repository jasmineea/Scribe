<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Modules\Listing\Entities\Listing;
use Modules\Listing\Entities\Contact;
use Modules\Order\Entities\Order;
use Modules\Transaction\Entities\Transaction;
use Illuminate\Http\Request;
use Modules\Order\Entities\MasterFiles;

class BackendController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ids = \DB::table('model_has_roles')->pluck('model_id');
        $customers=User::whereNotIn('id', $ids)->count();
        $orders=Order::count();
        $transactions=Transaction::count();
        $transaction_sum=Transaction::sum('amount');
        $contacts=Contact::count();
        $order_sum=Order::sum('order_amount');
        $listings=Listing::count();
        return view(
            'backend.index',
            compact('customers', 'orders', 'transactions', 'listings', 'transaction_sum', 'order_sum', 'contacts')
        );
    }
    public function search(Request $request)
    {
        $query=$request->query('query');
        $result=User::orWhere('name', 'like', '%' . $query . '%')->get();
        $result1=Order::orWhere('campaign_name', 'like', '%' . $query . '%')->get();
        $result2=Listing::orWhere('name', 'like', '%' . $query . '%')->get();
        $final_str='';
        foreach ($result as $key => $value) {
            $final_str.="<a href='".route('backend.customers.details',['id'=>$value['id']])."'>Customer: ".$value['name']." (#".$value['id'].") </a>";
        }
        foreach ($result1 as $key => $value) {
            $final_str.="<a href='".route('backend.orders.index',['s_id'=>$value['id']])."'>Campaigns: ".$value['campaign_name']." (#".$value['id'].") </a>";
        }
        foreach ($result2 as $key => $value) {
            $final_str.="<a href='".route('backend.listings.index',['s_id'=>$value['id']])."'>Recipient List: ".$value['name']." (#".$value['id'].") </a>";
        }
        echo $final_str;die;
    }
}
