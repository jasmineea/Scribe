<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\User;
use App\Models\UserPaymentMethod;
use App\Models\Order;
use App\Models\Transaction;
use Stripe;
use Session;
use Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Auth\Events\Registered;
use App\Events\Frontend\UserRegistered;
use Illuminate\Support\Facades\Hash;
use Modules\Listing\Entities\Listing;
use Modules\Listing\Entities\Contact;
use Modules\Order\Entities\MasterFiles;
use App\Events\Frontend\OrderPlaced;
use App\Events\Frontend\WalletRecharge;
use App\Notifications\NewRegistration;
use App\Models\MetaData;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $body_class = '';
        // return view('dashboard', compact('body_class'));
        return view('frontend.index', compact('body_class'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function step0(Request $request)
    {
        if (!$request->session()->has('final_array')) {
            $request->session()->put('final_array',['tags'=>['FIRST_NAME'=>'FIRST NAME','LAST_NAME'=>'LAST NAME'],'listing_id'=>0,'list_id'=>0]);
        }
        $campaigns = Order::where('user_id', auth()->user()->id)->whereIn('status',['payment-pending','pending','processing','draft'])->get();
        $final_array=$request->session()->get('final_array');
        return view('frontend.step0', compact('final_array','campaigns'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function step1(Request $request)
    {
        $final_array=$request->session()->get('final_array');
        $listings = Listing::where('user_id', auth()->user()->id)->get();
        return view('frontend.step1', compact('listings','final_array'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function step2(Request $request)
    {

        $final_array=$request->session()->get('final_array');
        if(empty($final_array['campaign_name'])){
            Session::flash('error', 'please complete the step 2 first.');
            return redirect()->route('frontend.cards.step2');
        }
        return view('frontend.step2', compact('final_array'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function step3(Request $request)
    {
        $final_array=$request->session()->get('final_array');
        if(empty($final_array['hwl_custom_msg'])){
            Session::flash('error', 'please complete the step 3 first.');
            return redirect()->route('frontend.cards.step3');
        }
        return view('frontend.step3', compact('final_array'));
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function step4(Request $request)
    {
        if ($request->get('payment_intent')) {
            $status=save_payment($request);
            if ($status) {
                Session::flash('success', 'Payment has been successfully processed.');
                return redirect()->route('frontend.cards.step4');
            } else {
                Session::flash('error', 'Payment failed.');
            }
        }
        $final_array=$request->session()->get('final_array');
        $preview_message=final_message(@$final_array['excel_data']['data'][2], $final_array['hwl_custom_msg'], $final_array['system_property_1']);
        $final_array['preview_image'] = generate_Preview_Image($preview_message);
        compress(public_path('img/preview/'.$final_array['preview_image']),public_path('img/preview/'.$final_array['preview_image']), 10);

        if(empty($final_array['system_property_1'])){
            Session::flash('error', 'please complete the step 4 first.');
            return redirect()->route('frontend.cards.step3a');
        }
        $request->session()->put('final_array', $final_array);

        return view('frontend.step4', compact('final_array'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function step5(Request $request)
    {
        if ($request->get('payment_intent')) {
            $status=save_payment($request);
            if ($status) {
                Session::flash('success', 'Payment has been successfully processed.');
                return redirect()->route('frontend.cards.step5');
            } else {
                Session::flash('error', 'Payment failed.');
            }
        }
        $final_array=$request->session()->get('final_array');
        if(empty($final_array['card_font'])){
            Session::flash('error', 'please complete the step 4 first.');
            return redirect()->route('frontend.cards.step4');
        }
        return view('frontend.step5', compact('final_array'));
    }
       /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function step0Update(Request $request)
    {
        $body_class = '';
        if ($request->isMethod('post')) {
            $data=$request->all();
            if($data['existing_campaign_id']){
               // $new_order_id=duplicateOrder($data['existing_campaign_id']);
                $order_detail=Order::find($data['existing_campaign_id'])->toArray();
                $decode_data=json_decode($order_detail['order_json'], true);
                $decode_data['step_0_action_2']=$data['step_0_action_2'];
                $decode_data['step_0_action']='old';
                $decode_data['existing_campaign_id']=$data['existing_campaign_id'];
                $request->session()->put('final_array', $decode_data);
                $request->session()->put('old_order_id',$data['existing_campaign_id']);
            }else{
                $final_array=$request->session()->get('final_array');
                if(@$final_array['step_0_action']=='old'&&$data['step_0_action']=='new'){
                    $request->session()->forget('final_array');
                    $request->session()->forget('old_order_id');
                    $final_array=array_merge(['tags'=>['FIRST_NAME'=>'FIRST NAME','LAST_NAME'=>'LAST NAME'],'listing_id'=>0,'list_id'=>0],$data);
                    $request->session()->put('final_array',$final_array);
                }
            }
            return redirect()->route('frontend.cards.step2');
        }
        return view('frontend.step1', compact('body_class'));
    }
        /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function step1Update(Request $request)
    {
        $body_class = '';
        if ($request->isMethod('post')) {
            $final_array=$request->session()->get('final_array');
            if (((!isset($final_array['upload_recipients'])||!empty($request->file('upload_recipients')))&&empty($request->get('listing_id')))) {
                $this->validate(
                    $request,
                    [
                    'upload_recipients' => 'required|file|mimes:xls,xlsx,csv'
                    ],
                    [
                        'upload_recipients.required' => 'Please Choose a Recipient file or Select Campaign List.'
                    ]
                );
                $excel_data=read_excel_data($request->file('upload_recipients'));
                $image_path = $request->file('upload_recipients')->storeAs('', 'uploaded_recipient_file_'.time().'.xlsx', 'public');
                unset($final_array['tags']);
                $final_array['listing_id']=0;
                $final_array['list_id']=0;
                $final_array['tags']=[];
                $request->session()->put('final_array',array_merge($final_array,['upload_recipients'=>$image_path,'rows'=>$request->get('file_rows'),'excel_data'=>$excel_data,'listing_id'=>0,'threshold'=>$request->get('threshold')]));
            }
            if (null!==@$request->get('listing_id')&&@$final_array['listing_id']!=$request->get('listing_id')&&!empty($request->get('listing_id'))) {
                $file_data = create_copy_excel_from_listing_id($request->get('listing_id'));
                $excel_data=read_excel_data($file_data['file_name'], 1);
                unset($final_array['tags']);
                if($file_data['rows']=='0'){
                    $final_array['tags']=['FIRST_NAME'=>'FIRST NAME','LAST_NAME'=>'LAST NAME'];
                }else{
                    $final_array['tags']=[];
                }
                
                $request->session()->put('final_array',array_merge($final_array,['upload_recipients'=>$file_data['file_name'],'rows'=>$file_data['rows'],'excel_data'=>$excel_data,'listing_id'=>$request->get('listing_id'),'list_id'=>$request->get('listing_id'),'threshold'=>$request->get('threshold')]));
            }

            $final_array=$request->session()->get('final_array');
            $final_array['threshold']=$request->get('threshold');
            $final_array['repeat_number']=$request->get('repeat_number');
            $final_array['campaign_name']=$request->get('campaign_name');
            $final_array['campaign_type']=$request->get('campaign_type');

            foreach ($final_array['excel_data']['header'] as $key => $value) {
                if(!empty($value)){
                    $final_array['tags'][$value]=$value;
                }
            }
            
            if($final_array['listing_id']!=0&&contact_count($final_array['listing_id'])==0&&$final_array['campaign_type']=='pending'){
                $final_array['show_save_draft']=1;
                $final_array['excel_data']['data']=[];
             }else{
                $final_array['show_save_draft']=0;
             }
            $request->session()->put('final_array', $final_array);

            return redirect()->route('frontend.cards.step3');
        }
        return view('frontend.step1', compact('body_class'));
    }

        /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function step2ListCreate(Request $request)
    {
        if ($request->isMethod('post')) {
            $final_array=$request->session()->get('final_array');
            if($request->campaign_list_name){
                $list = new Listing;
                $list->user_id = auth()->user()->id;
                $list->name = $request->campaign_list_name;
                $list->status = 'active';
                $list->save();
                $final_array['list_id']=$list->id;
            }else{
                Session::flash('error', 'please enter campaign list name first.');
            }
            $final_array['campaign_type']=$request->campaign_type;
            $final_array['campaign_name']=$request->campaign_name;
            $request->session()->put('final_array', $final_array);
        }
        return redirect()->route('frontend.cards.step2');
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function step2Update(Request $request)
    {
        $body_class = '';
        if ($request->isMethod('post')) {
            $step_2=$request->session()->get('step-2');
            if (((!isset($step_2['upload_recipients'])||!empty($request->file('upload_recipients')))&&empty($request->get('listing_id')))) {
                $this->validate(
                    $request,
                    [
                    'upload_recipients' => 'required|file|mimes:xls,xlsx,csv'
                    ],
                    [
                        'upload_recipients.required' => 'Please Choose a Recipient file or Select Campaign List.'
                    ]
                );
                $excel_data=read_excel_data($request->file('upload_recipients'));
                $image_path = $request->file('upload_recipients')->storeAs('', 'uploaded_recipient_file_'.time().'.xlsx', 'public');
                $request->session()->put('step-2', ['upload_recipients'=>$image_path,'rows'=>$request->get('file_rows'),'excel_data'=>$excel_data,'listing_id'=>0,'threshold'=>$request->get('threshold')]);
            }
            if (null!==$request->get('listing_id')&&$step_2['listing_id']!=$request->get('listing_id')&&!empty($request->get('listing_id'))) {
                $file_data = create_copy_excel_from_listing_id($request->get('listing_id'));
                $excel_data=read_excel_data($file_data['file_name'], 1);
                $request->session()->put('step-2', ['upload_recipients'=>$file_data['file_name'],'rows'=>$file_data['rows'],'excel_data'=>$excel_data,'listing_id'=>$request->get('listing_id'),'threshold'=>$request->get('threshold')]);
            }

            $step_2=$request->session()->get('step-2');
            $step_2['threshold']=$request->get('threshold');
            $step_2['repeat_number']=$request->get('repeat_number');

            $step_1=$request->session()->get('step-1');
            end($step_2['excel_data']['header']);
            $key = key($step_2['excel_data']['header']);

            foreach ($step_1['tags'] as $key_1 => $value_1) {
                if (!in_array($key_1, array_values($step_2['excel_data']['header']))) {
                    $key = ++$key;
                    $step_2['excel_data']['header'][$key]=$key_1;
                    $step_2['excel_data']['data'][3][$key_1]=$key_1;
                }
            }
            $request->session()->put('step-2', $step_2);

            return redirect()->route('frontend.cards.step3');
        }
        // return view('dashboard', compact('body_class'));
        return view('frontend.step2', compact('body_class'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function step3Update(Request $request)
    {
        $body_class = '';
        if ($request->isMethod('post')) {
            $data=$request->all();
            $final_array=$request->session()->get('final_array');
            $request->session()->put('final_array',array_merge($final_array,$data));
            return redirect()->route('frontend.cards.step3a');
        }
        // return view('dashboard', compact('body_class'));
        return view('frontend.step3', compact('body_class'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function step3aUpdate(Request $request)
    {
        $body_class = '';
        if ($request->isMethod('post')) {
            $data=$request->all();
            $final_array=$request->session()->get('final_array');
            $request->session()->put('final_array',array_merge($final_array,$data));
            return redirect()->route('frontend.cards.step4');
        }
        // return view('dashboard', compact('body_class'));
        return view('frontend.step3', compact('body_class'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function step4Update(Request $request)
    {
        $body_class = '';
        if ($request->isMethod('post')) {
            $data=$request->all();
            $final_array=$request->session()->get('final_array');
            $request->session()->put('final_array',array_merge($final_array,$data));
            return redirect()->route('frontend.cards.step5');
        }
        // return view('dashboard', compact('body_class'));
        return view('frontend.step4', compact('body_class'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function step5Update(Request $request)
    {
        ini_set('max_execution_time', 1000);
        if ($request->isMethod('post')) {
            $data=$request->all();
            $final_array=$request->session()->get('final_array');
            $request->session()->put('final_array',array_merge($final_array,$data));


            $order_data=$request->session()->get('final_array');

            if ($order_data['campaign_type']=='pending') {
                $transaction = new Transaction;
                $transaction->user_id = auth()->user()->id;
                $transaction->amount = count($order_data['excel_data']['data'])*credit_exchange_rate();
                $transaction->wallet_balance = auth()->user()->wallet_balance-$transaction->amount;
                $transaction->status = 1;
                $transaction->type = 'Dr';
                $transaction->payment_method = 'Scribe Credit';
                $transaction->comment = 'Order  Payment';
                $transaction->transaction_json =json_encode($order_data);
                $transaction->currency_amount =0;
                $transaction->save();

                if ($request->session()->get('old_order_id')) {
                    $order = Order::find($request->session()->get('old_order_id'));
                    if(empty($order)){
                        $order = new Order;
                    }
                    if(@$order_data['step_0_action_2']=='duplicate_existing'){
                        $order = new Order;
                    }
                    // if ($order_data['list_id']) {
                    //     $order=Order::updateOrCreate(
                    //         [
                    //             'user_id' => auth()->user()->id,
                    //             'status' => 'draft',
                    //             'listing_id' => $order_data['list_id']
                    //         ]
                    //     );
                } else {
                    $order = new Order;
                }

                $order->user_id = auth()->user()->id;
                $order->order_amount= count($order_data['excel_data']['data'])*credit_exchange_rate();
                $order->status= $order_data['publish_type'];
                if(@$order_data['step_0_action_2']=='duplicate_existing'){
                    $order->campaign_name= $order_data['campaign_name']." Copy";
                }else{
                    $order->campaign_name= $order_data['campaign_name'];
                }
                $order->campaign_type= $order_data['campaign_type']=='on-going'?'on-going':'one-time';
                $order->campaign_message= 'order_'.$order_data['preview_image'];
                $order->schedule_status= $order_data['publish_type']=='schedule'?1:0;
                $order->auto_charge= $order_data['auto_charge']?1:0;
                $order->threshold= $order_data['threshold']?$order_data['threshold']:0;
                $order->repeat_number= $order_data['repeat_number']?$order_data['repeat_number']:0;
                $order->payment_method_id= isset($order_data['payment_method_id'])?$order_data['payment_method_id']:0;
                $order->uploaded_recipient_file= $order_data['upload_recipients'];
                $order->final_printing_file= $order_data['upload_recipients'];
                $order->order_json= json_encode($order_data);
                $order->transaction_id = $transaction->id;
                $order->save();

                $user = User::find(auth()->user()->id);
                $user->wallet_balance = $transaction->wallet_balance;
                $user->save();

                $transaction = Transaction::find($transaction->id);
                $transaction->order_id = $order->id;
                $transaction->comment = 'Order #'.$order->id.' Payment';
                $transaction->save();

                if ($order_data['listing_id']) {
                    $list_id=$order_data['listing_id'];
                } else {
                    $list = new Listing;
                    $list->user_id = auth()->user()->id;
                    $list->name = 'List '.$order->id;
                    $list->status = 'active';
                    $list->save();
                    $list_id=$list->id;
                }
                
                rename(public_path('img/preview/'.$order_data['preview_image']),public_path('img/preview/order_'.$order_data['preview_image']));
                $order_data['preview_image']='order_'.$order_data['preview_image'];

                $order = Order::find($order->id);
                $order->listing_id = $list_id;
                $order->order_json= json_encode($order_data);
                $order->save();

                if ($order_data['listing_id']==0) {
                    $url = route('frontend.cards.createcontacts', ['order_id' =>$order->id,'start'=>0]);
                    curl_url_hit($url);
                }

                event(new OrderPlaced($user, $order));
            } else {
                if ($request->session()->get('old_order_id')) {
                    $order = Order::find($request->session()->get('old_order_id'));
                    if(empty($order)){
                        $order = new Order;
                    }
                    if(@$order_data['step_0_action_2']=='duplicate_existing'){
                        $order = new Order;
                    }
                } else {
                    $order = new Order;
                }

                $order_data['threshold']=$order_data['threshold']?$order_data['threshold']:10;

                $order->user_id = auth()->user()->id;
                $order->order_amount= 0;
                $order->status= $order_data['publish_type'];
                if(@$order_data['step_0_action_2']=='duplicate_existing'){
                    $order->campaign_name= $order_data['campaign_name']." Copy";
                }else{
                    $order->campaign_name= $order_data['campaign_name'];
                }
                
                $order->campaign_type= $order_data['campaign_type']=='on-going'?'on-going':'one-time';
                $order->campaign_message= 'order_'.$order_data['preview_image'];
                $order->schedule_status= $order_data['publish_type']=='schedule'?1:0;
                $order->auto_charge= $order_data['auto_charge']?1:0;
                $order->threshold= $order_data['threshold']?$order_data['threshold']:10;
                $order->repeat_number= $order_data['repeat_number']?$order_data['repeat_number']:0;
                $order->payment_method_id= isset($order_data['payment_method_id'])?$order_data['payment_method_id']:0;
                $order->uploaded_recipient_file= '';
                $order->final_printing_file= '';
                $order->order_json= json_encode($order_data);
                $order->transaction_id = 0;
                $order->save();

                if ($order_data['listing_id']) {
                    $list_id=$order_data['listing_id'];
                } else {
                    $list = new Listing;
                    $list->user_id = auth()->user()->id;
                    $list->name = 'List '.$order->id;
                    $list->status = 'active';
                    $list->save();
                    $list_id=$list->id;
                }
                
                rename(public_path('img/preview/'.$order_data['preview_image']),public_path('img/preview/order_'.$order_data['preview_image']));
                $order_data['preview_image']='order_'.$order_data['preview_image'];

                $order = Order::find($order->id);
                $order->listing_id = $list_id;
                $order->order_json= json_encode($order_data);
                $order->save();

                if ($order_data['listing_id']==0) {
                    $url = route('frontend.cards.createcontacts', ['order_id' =>$order->id,'start'=>0]);
                    curl_url_hit($url);
                }
            }


            $request->session()->forget('final_array');
            $request->session()->forget('old_order_id');

            return redirect()->route('frontend.cards.thankYou');
        }
        return view('frontend.step4', compact('body_class'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function thankYou()
    {
        $body_class = '';

        // return view('dashboard', compact('body_class'));
        return view('frontend.thankyou', compact('body_class'));
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function wallet(Request $request)
    {
        if ($request->get('payment_intent')) {
            $status=save_payment($request);

            if ($status) {
                Session::flash('success', 'Payment has been successfully processed.');
            } else {
                Session::flash('error', 'Payment failed.');
            }

            return redirect()->route('frontend.cards.wallet');
        }
        $transactions = Transaction::where('user_id', auth()->user()->id)->orderBy('id', 'desc')->paginate(10);
        return view('frontend.wallet', compact('transactions'));
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function orders()
    {
        $paymentMethodCount=UserPaymentMethod::where('user_id', auth()->user()->id)->count();
        $orders = Order::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->paginate(10);
        return view('frontend.order', compact('orders','paymentMethodCount'));
    }

    public function listing()
    {
        $listings = Listing::where('user_id', auth()->user()->id)->paginate(10);
        return view('frontend.listing', compact('listings'));
    }

    public function contacts($id)
    {
        $file = Listing::where('id', $id)->first();
        $contacts = Contact::where('listing_id', $id)->orderBy('id', 'desc')->paginate(10);
        if (true) {
            $file=create_copy_excel_from_listing_id($id);
            $file['uploaded_recipient_file']=$file['file_name'];
        }
        return view('frontend.contact', compact('contacts', 'file', 'id'));
    }

    public function files($file)
    {
        return Storage::disk('public')->download($file);
    }

    public function exportFile($list_id){
        $file=export_file_from_list_id($list_id);
        return Storage::disk('public')->download($file);
    }

    public function createStripeElement(Request $request)
    {
        $amount=$request->get('amount');
        return view('frontend.create-stripe-element', compact('amount'));
    }
    public function createStripeElementPopup(Request $request)
    {
        $amount=$request->get('amount');
        return view('frontend.create-stripe-element-popup', compact('amount'));
    }

    public function createStripeToken(Request $request)
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            if (auth()->user()->stripe_customer_id) {
                $customer_id=auth()->user()->stripe_customer_id;
            } else {
                \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

                $customer = \Stripe\Customer::create([
                    'email' => auth()->user()->email,
                ]);
                $customer_id=$customer->id;
                $user = User::find(auth()->user()->id);
                $user->stripe_customer_id = $customer_id;
                $user->save();
            }
            // Create a PaymentIntent with amount and currency
            $paymentIntent = \Stripe\PaymentIntent::create([
                'customer' => $customer_id,
                'setup_future_usage' => 'off_session',
                'amount' => $request->get('amount')*100,
                'currency' => 'usd',
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
            ]);

            $output = [
                'clientSecret' => $paymentIntent->client_secret,
            ];

            echo json_encode($output);
        } catch (Error $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
        die;
    }

    public function deductPaymentFromSavedCard(Request $request)
    {
        if ($request->isMethod('post')) {
            $userPaymentMethod = UserPaymentMethod::find($request->get('payment_id'));
            $amount=$request->get('amount');
            if ($userPaymentMethod['payment_method_type']=='square') {
                $result=create_square_payment($amount, $request->get('payment_id'), $request->get('order_id'));
            } else {
                $stripe = new \Stripe\StripeClient(
                    env('STRIPE_SECRET')
                );
                if ($request->get('payment_id')) {
                    try {
                        $payment = $stripe->paymentIntents->create([
                            'amount' => $amount,
                            'currency' => 'usd',
                            'customer' => $userPaymentMethod['pm_user_id'],
                            'payment_method' => $userPaymentMethod['payment_method'],
                            'off_session' => true,
                            'confirm' => true,
                        ]);
                        $amount=$payment['amount']/100;
                        $c_amount=$payment['amount']/100;
                        $credit_exchange_rate=credit_exchange_rate();
                        $amount=$amount/$credit_exchange_rate;

                        if (isset($payment['status']) && $payment['status'] =="succeeded") {
                            $transaction = new Transaction;
                            $transaction->user_id = auth()->user()->id;
                            $transaction->amount = $amount;
                            $transaction->wallet_balance = auth()->user()->wallet_balance+$amount;
                            $transaction->status = 1;
                            $transaction->currency_amount = $c_amount;
                            $transaction->payment_method = 'Card';
                            $transaction->type = 'Cr';
                            $transaction->comment = 'Wallet Recharge';
                            $transaction->transaction_json =json_encode($payment);
                            $transaction->online_transaction_id =$payment['id'];
                            $transaction->save();

                            $user = User::find(auth()->user()->id);
                            $user->wallet_balance = $transaction->wallet_balance;
                            $user->save();
                            event(new WalletRecharge($user, $transaction));
                            Session::flash('success', 'Payment has been successfully processed.');
                        } else {
                            $transaction = new Transaction;
                            $transaction->user_id = auth()->user()->id;
                            $transaction->amount = $amount;
                            $transaction->wallet_balance = auth()->user()->wallet_balance;
                            $transaction->status = 0;
                            $transaction->currency_amount = $c_amount;
                            $transaction->payment_method = 'Card';
                            $transaction->type = 'Cr';
                            $transaction->comment = 'Wallet Recharge';
                            $transaction->transaction_json =json_encode($payment);
                            $transaction->online_transaction_id =$payment['id'];
                            $transaction->save();
                            Session::flash('error', 'Payment failed.');
                        }
                    } catch(\Exception $e) {
                        $transaction = new Transaction;
                        $transaction->user_id = auth()->user()->id;
                        $transaction->amount = $amount/100;
                        $transaction->wallet_balance = auth()->user()->wallet_balance;
                        $transaction->status = 0;
                        $transaction->currency_amount = $amount/100;
                        $transaction->payment_method = 'Card';
                        $transaction->type = 'Cr';
                        $transaction->comment = 'Wallet Recharge Failed'.$e->getMessage();
                        $transaction->transaction_json =json_encode($e);
                        $transaction->online_transaction_id ='';
                        $transaction->save();
                        Session::flash('error', 'Payment failed.');
                    }
                }
            }
        }
        return redirect()->back();
    }
    public function squareupPage(Request $request)
    {
        $amount=1;
        $user_id=6;
        return view('frontend.sqaure-up-page', compact('amount', 'user_id'));
    }
    public function paymentResponse(Request $request)
    {
        $result=save_card_on_file($request->get('idempotencyKey'), $request->get('verificationToken'));
        echo json_encode($result);
        die;
    }

    public function storeCard(Request $request)
    {
        $result=save_card_on_file($request->get('idempotencyKey'), $request->get('sourceId'), $request->get('amount'), $request->get('future_payment'), $request->get('order_id'));
        return response($result, 200)
                  ->header('Content-Type', 'text/plain');
    }
    public function termConditions()
    {
        return view('frontend.term-conditions');
    }
    public function zapierImport()
    {
        return view('frontend.zapier-import');
    }
    public function makeImport()
    {
        return view('frontend.make-import');
    }
    public function deleteCard(Request $request)
    {
        UserPaymentMethod::where('id', $request->get('id'))->delete();
        return response(['message'=>'Record deleted.'], 200)
                  ->header('Content-Type', 'text/plain');
    }
    public function orderDetail($id)
    {
        $order_detail=Order::find($id)->toArray();

        $file = Listing::where('id', $order_detail['listing_id'])->first();
        $contacts = Contact::where('listing_id', $order_detail['listing_id'])->paginate(10);
        if (empty($file['uploaded_recipient_file'])) {
            $file=create_copy_excel_from_listing_id($order_detail['listing_id']);
        }
        return view('frontend.order-detail', compact('order_detail', 'contacts', 'file', 'id'));
    }
    public function orderEdit(Request $request, $id)
    {
        $order_detail=Order::find($id)->toArray();
        $decode_data=json_decode($order_detail['order_json'], true);
        $request->session()->put('final_array', $decode_data);
        $request->session()->put('old_order_id', $id);
        return redirect()->route('frontend.cards.step2');
    }
    public function updateStatus(Request $request, $id, $status)
    {
        if ($request->isMethod('post')) {
            $this->validate(
                $request,
                [
                'payment_method_id' => 'required'
                ],
                [
                    'payment_method_id.required' => 'Please select payment card.'
                ]
            );

            $order = Order::find($id);
            $order->status = $status;
            $order->payment_method_id = $request->get('payment_method_id');
            $order->save();
            Session::flash('success', 'Status updated successfully.');
        }else{
            $order = Order::find($id);
            $order->status = $status;
            $order->save();
            Session::flash('success', 'Status updated successfully.');
        }
        return redirect()->route('frontend.cards.orders');
    }
    public function duplicateOrder($id)
    {
        duplicateOrder($id);
        Session::flash('success', 'New order created from existing order.');
        return redirect()->back();
    }


    public function autoCreateOrder($type='')
    {
        auto_create_order();
        if($type){
            Log::info(label_case('order created from on going order').' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');
            Session::flash('success', 'orders fetched successfully.');
            return redirect()->route('backend.orders.index',['type'=>'published']);
        }else{
            Log::info(label_case('order created from cron'));
        }
        die;
    }
    public function generateFiles($id,$type='')
    {
        $order = Order::find($id);
        create_copy_excel_from_listing_id($order->listing_id);
        create_copy_excel($order->id);
        Session::flash('success', 'Files generated successfully.');
        if($type){
            return redirect()->back();
        }else{
            return redirect()->route('frontend.cards.orderDetail',$id);
        }

    }
    public function uploadFile(Request $request)
    {
       
        if ($request->isMethod('post')) {

            $list_id=$request->get('list_id');
            $excel_data=read_excel_data($request->file('upload_recipients'));
            foreach ($excel_data['data'] as $key => $value) {
                if(@!isset($value['ID'])){
                    $value['ID']=0;
                }
                $contact=Contact::updateOrCreate(
                    [
                        'id' => @trim($value['ID']),
                        'listing_id' => $list_id
                    ],
                    [
                        'first_name' => @trim($value['FIRST_NAME']),
                        'last_name' => @trim($value['LAST_NAME']),
                        'company_name' => @trim($value['COMPANY_NAME']),
                        'email' => @trim($value['EMAIL']),
                        'phone' => @trim($value['PHONE']),
                        'address' => @trim($value['ADDRESS']),
                        'city' => @trim($value['CITY']),
                        'state' => @trim($value['STATE']),
                        'zip' => @trim($value['ZIP']),
                        'message' => @trim($value['MESSAGE'])
                    ]
                );
                foreach ($value as $key1 => $value1) {
                    if (!in_array($key1, ['ID','EMAIL','FIRST_NAME','LAST_NAME','COMPANY_NAME','PHONE','ADDRESS','CITY','STATE','ZIP','MESSAGE'])) {
                        MetaData::updateOrCreate([
                            'meta_id' => $contact->id,
                            'type' => 'contact',
                            'meta_key' => $key1
                        ], [
                            'meta_value' => $value1
                        ]);
                    }
                }
                
            }
        
            create_copy_excel_from_listing_id($list_id);
            $order=Order::where('listing_id', $list_id)->first();
            create_copy_excel($order->id);
            Session::flash('success', 'File uploaded successfully.');
           
        }
        return redirect()->back();
    }
    public function createMasterFile($type=''){
        ini_set("memory_limit", "-1");
        set_time_limit(0);
        auto_create_order();

        $master_file_record_limit = setting('master_file_record_limit');
        $final_message=[];
        $orders = Order::where('campaign_type', 'one-time')->where('status', 'pending')->get();
        $i=0;

        foreach ($orders as $key => $value) {
            create_copy_excel_from_listing_id($value->listing_id);
            create_copy_excel($value->id);
            $latest_order=Order::find($value->id);
            $order_json=read_excel_data($latest_order->final_printing_file, 1);

            foreach ($order_json['data'] as $key_1 => $value_1) {
                $final_message[$i]['order_date']=date('Y-m-d H:i:s',strtotime($value->created_at));
                $final_message[$i]['order_id']=$value->id;
                $final_message[$i]['order_name']=$value->campaign_name;
                $final_message[$i]['order_owner']=$value->user->name;
                $final_message[$i]['order_status']=$value->status;
                $final_message[$i]['first_name']=$value_1['FIRST_NAME'];
                $final_message[$i]['last_name']=$value_1['LAST_NAME'];
                $final_message[$i]['email']=$value_1['EMAIL'];
                $final_message[$i]['company_name']=$value_1['COMPANY_NAME'];
                $final_message[$i]['phone']=$value_1['PHONE'];
                $final_message[$i]['address']=$value_1['ADDRESS'];
                $final_message[$i]['city']=$value_1['CITY'];
                $final_message[$i]['state']=$value_1['STATE'];
                $final_message[$i]['zip']=$value_1['ZIP'];
                $final_message[$i]['final_message']=$value_1['FINAL_PRINTING_MESSAGE'];

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
            if($order_json['data']){
                $order=Order::find($value->id);
                $order->status='processing';
                $order->save();
            }
        }
        if($final_message){
            $return_file_name=create_excel_for_master_file($final_message);
            MasterFiles::create([
                'uploaded_recipient_file' => trim($return_file_name['file_name']),
                'total_records' => count($final_message)
            ]);
        }
        if($type){
            Log::info(label_case('master file created from on going order').' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');
            Session::flash('success', 'Master file created successfully.');
            return redirect()->route('backend.orders.masterfiles');
        }else{
            Log::info(label_case('master file created from cron'));
        }
        die;
    }
    public function createcontacts($order_id,$start){
        $limit=50;
        $order_detail=Order::find($order_id)->toArray();
        $order_data=json_decode($order_detail['order_json'], true);
        $order_loop_contact=array_slice($order_data['excel_data']['data'],$start, $limit);
        if(count($order_loop_contact)>0){
            foreach ($order_loop_contact as $key => $value) {
                $contact=Contact::create([
                    'first_name' => isset($value['FIRST_NAME'])?trim($value['FIRST_NAME']):trim($value[$order_data['system_property_2']['FIRST_NAME']]),
                    'last_name' => isset($value['LAST_NAME'])?trim($value['LAST_NAME']):trim($value[$order_data['system_property_2']['LAST_NAME']]),
                    'company_name' => isset($value['COMPANY_NAME'])?trim($value['COMPANY_NAME']):@trim($value[$order_data['system_property_1']['COMPANY_NAME']]),
                    'email' => isset($value['EMAIL'])?trim($value['EMAIL']):@trim($value[$order_data['system_property_1']['EMAIL']]),
                    'phone' => isset($value['PHONE'])?trim($value['PHONE']):@trim($value[$order_data['system_property_1']['PHONE']]),
                    'address' => isset($value['ADDRESS'])?trim($value['ADDRESS']):trim($value[$order_data['system_property_2']['ADDRESS']]),
                    'city' => isset($value['CITY'])?trim($value['CITY']):trim($value[$order_data['system_property_2']['CITY']]),
                    'state' => isset($value['STATE'])?trim($value['STATE']):trim($value[$order_data['system_property_2']['STATE']]),
                    'zip' => isset($value['ZIP'])?trim($value['ZIP']):trim($value[$order_data['system_property_2']['ZIP']]),
                    'listing_id' => $order_detail['listing_id']
                ]);
                foreach ($value as $key_1 => $value_1) {
                    if (!in_array($key_1, ['FIRST_NAME','LAST_NAME','COMPANY_NAME','EMAIL','PHONE','ADDRESS','CITY','STATE','ZIP'])) {
                        MetaData::create([
                            'listing_id' => $order_detail['listing_id'],
                            'order_id' => $order_detail['id'],
                            'meta_id' => $contact->id,
                            'type' => 'contact',
                            'meta_key' => $key_1,
                            'meta_value' => $value_1
                        ]);
                    }
                }
            }
            $url = route('frontend.cards.createcontacts', ['order_id' =>$order_id,'start'=>$start+$limit]);
            curl_url_hit($url);
        }else{
            create_copy_excel($order_id);
        }
        die;
    }
    public function uploadPreBccFile(Request $request){
        if ($request->isMethod('post')) {
                $this->validate(
                    $request,
                    [
                    'upload_post_file' => 'required|file|mimes:xls,xlsx,csv'
                    ],
                    [
                        'upload_post_file.required' => 'Please Choose a Pre BCC File.'
                    ]
                );
                $orignal_name = $request->upload_post_file->getClientOriginalName();
                $image_path = $request->file('upload_post_file')->storeAs('', "Post_BCC_".$orignal_name, 'public');
                $order = MasterFiles::find($request->get('master_id'));
                $order->post_uploaded_recipient_file = $image_path;
                $order->save();
                replace_message_id_with_message($request->get('master_id'));
                Session::flash('success', 'Post BCC File Generated Successfully.');
                return redirect()->route('backend.orders.masterfiles');
        }
    }
}
