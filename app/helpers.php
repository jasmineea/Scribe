<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\User;
use App\Models\Order;
use Modules\Listing\Entities\Listing;
use Modules\Listing\Entities\Contact;
use Modules\Order\Entities\MasterFiles;
use App\Models\Transaction;
use App\Models\UserPaymentMethod;
use App\Events\Frontend\WalletRecharge;
use App\Events\Frontend\OrderPlaced;
use App\Models\MetaData;
use App\Models\MasterFileMessage;
use GDText\Box;
use GDText\Color;
// use Stripe;
use Illuminate\Support\Facades\Session;

/*
 * Global helpers file with misc functions.
 */
if (! function_exists('app_name')) {
    /**
     * Helper to grab the application name.
     *
     * @return mixed
     */
    function app_name()
    {
        return config('app.name');
    }
}
function rotateImage($filename){
    ob_start();
    $degrees        = 90;

    // open the image file
    $im = imagecreatefrompng(public_path("storage/".$filename));

    // create a transparent "color" for the areas which will be new after rotation
    // r=0,b=0,g=0 ( black ), 127 = 100% transparency - we choose "invisible black"
    $transparency = imagecolorallocatealpha( $im,0,0,0,127 );

    // rotate, last parameter preserves alpha when true
    $rotated = imagerotate( $im, $degrees, $transparency, 1);

    // disable blendmode, we want real transparency
    imagealphablending( $rotated, false );
    // set the flag to save full alpha channel information
    imagesavealpha( $rotated, true );

    // now we want to start our output
    ob_end_clean();
    // we send image/png
    header( 'Content-Type: image/png' );
    imagepng( $rotated,public_path("storage/".$filename));
    // clean up the garbage
    imagedestroy( $im );
    imagedestroy( $rotated );
}
function createFinalPrintImage($image1,$image2,$image3,$image4){
    // rotateImage($image1);die;
    $dest = imagecreatefrompng(public_path('img/solid-color-image.png'));
    $src1 = imagecreatefrompng(public_path("storage/".$image1));
    // $imgResized = imagescale($src1 , 1250, 864);
    // imagepng($imgResized,public_path("storage/".$image1));
    // $src1 = imagecreatefrompng(public_path("storage/".$image1));
    $src2 = imagecreatefrompng(public_path("storage/".$image2));
    $src3 = imagecreatefrompng(public_path("storage/".$image3));
    $src4 = imagecreatefrompng(public_path("storage/".$image4));
    
    imagealphablending($dest, false);
    imagesavealpha($dest, true);
    
    imagecopymerge($dest, $src1, 20, 20, 0, 0, 1250, 864, 100); //have to play with these numbers for it to work for you, etc.
    imagecopymerge($dest, $src2, 1300, 20, 0, 0, 1250, 864, 100); //have to play with these numbers for it to work for you, etc.
    imagecopymerge($dest, $src3, 20, 900, 0, 0, 1250, 864, 100); //have to play with these numbers for it to work for you, etc.
    imagecopymerge($dest, $src4, 1300, 900, 0, 0, 1250, 864, 100); //have to play with these numbers for it to work for you, etc.
    
    header('Content-Type: image/png');
    imagepng($dest,public_path("storage/card_design/final.png"));
    
    imagedestroy($dest);
    imagedestroy($src1);
    imagedestroy($src2);
    imagedestroy($src3);
    imagedestroy($src4);

}
function getDPIImageMagick($filename){
    $im = imagecreatefromstring(file_get_contents(public_path("storage/".$filename)));
    $image_dpi=imageresolution($im);
    imagedestroy($im);
    return $image_dpi[0];
}
function divideImage($filename='a.jpg',$extension='',$divide='100%x50%'){
    $file_path=public_path("storage/card_design/".$filename.'.'.$extension);
    exec('convert -crop '.$divide.' '.$file_path.' '.public_path("storage/card_design/cropped/".$filename."_%d".".".$extension));
    return 1;
}
function get_dpi($filename){
    $a = fopen(public_path('storage/'.$filename),'r');
    $string = fread($a,20);
    fclose($a);

    $data = bin2hex(substr($string,14,4));
    $x = substr($data,0,4);
    $y = substr($data,0,4);

    return array(hexdec($x),hexdec($y));
} 
function image_resize($filename, $percent) {
   

    // Content type
    header('Content-Type: image/png');

    // Get new sizes
    list($width, $height) = getimagesize($filename);
    $newwidth = $width * $percent;
    $newheight = $height * $percent;

    // Load
    $thumb = imagecreatetruecolor($newwidth, $newheight);
    $source = imagecreatefrompng($filename);

    // Resize
    imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

    // Output
    imagepng($thumb,$filename);
 }
function imagecopymerge_alpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct){ 
    // creating a cut resource 
    $cut = imagecreatetruecolor($src_w, $src_h); 

    // copying relevant section from background to the cut resource 
    imagecopy($cut, $dst_im, 0, 0, $dst_x, $dst_y, $src_w, $src_h); 

    // copying relevant section from watermark to the cut resource 
    imagecopy($cut, $src_im, 0, 0, $src_x, $src_y, $src_w, $src_h); 

    // insert cut resource to destination image 
    imagecopymerge($dst_im, $cut, $dst_x, $dst_y, 0, 0, $src_w, $src_h, $pct); 
} 
function mergeTwoImages(){

   // image_resize(public_path("storage/card_design/a.png"),0.80);

    $base = imagecreatefrompng(public_path("storage/card_design/a.png"));
    $size = getimagesize(public_path("storage/card_design/Back.png"));
    $logo1 = public_path("storage/card_design/Back.png");
    $logo = imagecreatefrompng($logo1);
    imagecopymerge_alpha($base, $logo, 0, 0, 0, 0,$size[0], $size[1], 100);
    header('Content-Type: image/png');
    imagepng($base,public_path("storage/card_design/stamp.png"));



     # If you don't know the type of image you are using as your originals.
    // $image = imagecreatefromstring(file_get_contents(public_path("storage/card_design/a.png")));
    // $frame = imagecreatefromstring(file_get_contents(public_path("storage/card_design/aa.png")));

    // # If you know your originals are of type PNG.
    // $image = imagecreatefrompng(public_path("storage/card_design/a.png"));
    // $frame = imagecreatefrompng(public_path("storage/card_design/aa.png"));

    // imagecopymerge($image, $frame, 0, 0, 0, 0, 700, 700, 100);

    // # Save the image to a file
    // header('Content-Type: image/png');
    // imagepng($image,public_path("storage/card_design/stamp.png"));

    // # Output straight to the browser.
    // imagepng($image);

    // $dest = @imagecreatefrompng(public_path("storage/card_design/a.png"));
    // $src = @imagecreatefrompng(public_path("storage/card_design/Back.png"));

    // // Copy and merge
    // imagecopymerge($dest, $src, 0, 0, 0, 0, 500, 500, 100);

    // // Output and free from memory
    // header('Content-Type: image/png');
    // imagepng($dest, public_path("storage/card_design/stamp.png"));


    // $src = imagecreatefromjpeg(public_path("storage/card_design/b1.jpg"));
    // $dest = imagecreatefrompng(public_path("storage/card_design/Back.png"));

    // imagealphablending($dest, false);
    // imagesavealpha($dest, true);
    // imagealphablending($src, false);
    // imagesavealpha($src, true);

    // $insert_x = imagesx($src); 
    // $insert_y = imagesy($src);

    // $white = imagecolorallocatealpha($dest, 255, 255, 255, 127); 
    // imagecolortransparent($dest, $white);
    // imagecopymerge($src, $dest, 0, 0, 0, 0, $insert_x, $insert_y, 100); 

    // header('Content-Type: image/jpeg');
    // imagejpeg($src, public_path("storage/card_design/stamp.jpeg"));

    // imagedestroy($dest);
    // imagedestroy($src);

    // $im = imagecreatefrompng(public_path("storage/card_design/a.png"));
    // $top_img = imagecreatefrompng(public_path("storage/card_design/Back.png"));

    // // First we create our stamp image manually from GD
    // // $stamp = imagecreatetruecolor(100, 70);
    // // imagefilledrectangle($stamp, 0, 0, 99, 69, 0x0000FF);
    // // imagefilledrectangle($stamp, 9, 9, 90, 60, 0xFFFFFF);
    // // imagestring($stamp, 5, 20, 20, 'libGD', 0x0000FF);
    // // imagestring($stamp, 3, 20, 40, '(c) 2007-9', 0x0000FF);

    // // Set the margins for the stamp and get the height/width of the stamp image
    // $marge_right = 10;
    // $marge_bottom = 10;
    // $sx = imagesx($top_img);
    // $sy = imagesy($top_img);

    // // Merge the stamp onto our photo with an opacity of 50%
    // imagecopymerge($im, $top_img, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($top_img), imagesy($top_img), 100);

    // // Save the image to file and free memory
    // imagepng($im, public_path("storage/card_design/stamp.png"));
    // imagedestroy($im);

}
if (! function_exists('create_square_customer_id')) {
    function create_square_customer_id($first_name, $last_name, $email)
    {
        $client = new \Square\SquareClient([
            'accessToken' => setting('squareup_access_token'),
            'environment' => setting('squareup_environment')=='live'?\Square\Environment::PRODUCTION:\Square\Environment::SANDBOX,
        ]);
        $address = new \Square\Models\Address();
        $address->setAddressLine1('500 Electric Ave');
        $address->setAddressLine2('Suite 600');
        $address->setLocality('New York');
        $address->setAdministrativeDistrictLevel1('NY');
        $address->setPostalCode('10003');
        $address->setCountry('US');

        $body = new \Square\Models\CreateCustomerRequest();
        $body->setGivenName($first_name, $email);
        $body->setFamilyName($last_name);
        $body->setEmailAddress($email);
        $body->setAddress($address);
        $body->setNote('a customer');

        $api_response = $client->getCustomersApi()->createCustomer($body);

        if ($api_response->isSuccess()) {
            $result = $api_response->getResult();
            $result=json_decode(json_encode($result), true);
            $user = User::find(auth()->user()->id);
            $user->square_customer_id = $result['customer']['id'];
            $user->save();
        } else {
            $result = $api_response->getErrors();
        }
        return json_decode(json_encode($result), true);
    }
}
if (! function_exists('save_card_on_file')) {
    function save_card_on_file($UNIQUE_KEY, $CARD_TOKEN, $amount, $saved_for_future, $order_id=0)
    {
        if (empty(auth()->user()->square_customer_id)) {
            create_square_customer_id(auth()->user()->first_name, auth()->user()->last_name, auth()->user()->email);
            $user = User::find(auth()->user()->id);
            Auth::login($user);
        }
        $client = new \Square\SquareClient([
            'accessToken' => setting('squareup_access_token'),
            'environment' => setting('squareup_environment')=='live'?\Square\Environment::PRODUCTION:\Square\Environment::SANDBOX,
        ]);

        $card = new \Square\Models\Card();
        $card->setCardholderName(auth()->user()->name);
        $card->setCustomerId(auth()->user()->square_customer_id);

        $body = new \Square\Models\CreateCardRequest(
            $UNIQUE_KEY,
            $CARD_TOKEN,
            $card
        );

        $api_response = $client->getCardsApi()->createCard($body);

        if ($api_response->isSuccess()) {
            $result = $api_response->getResult();
            $payment=json_decode(json_encode($result), true);
            $card_data=UserPaymentMethod::firstOrCreate(
                ['user_id' => auth()->user()->id,'pm_user_id'=>auth()->user()->square_customer_id,'payment_method'=>$payment['card']['id']],
                ['status' => '1','card_type' =>$payment['card']['card_brand'],'last_4_digits' =>$payment['card']['last_4'],'expiry_date' =>$payment['card']['exp_month']."/".$payment['card']['exp_year'],'payment_method_type'=>'square','is_default'=>1]
            );
            if ($amount!=0) {
                create_square_payment($amount, $card_data->id, $order_id);
            }
            if ($saved_for_future==0) {
                UserPaymentMethod::where('id', $card_data->id)->delete();
            }
        } else {
            Session::flash('error', 'Payment failed.');
            $result = $api_response->getErrors();
        }
        return json_decode(json_encode($result), true);
    }
}

if (! function_exists('create_square_payment')) {
    function create_square_payment($amount, $cart_id, $order_id=0)
    {
        $c_amount=per_credit_price($amount)*$amount;
        $userPaymentMethod = UserPaymentMethod::find($cart_id);
        $client = new \Square\SquareClient([
            'accessToken' => setting('squareup_access_token'),
            'environment' => setting('squareup_environment')=='live'?\Square\Environment::PRODUCTION:\Square\Environment::SANDBOX,
        ]);
        $amount_money = new \Square\Models\Money();
        $amount_money->setAmount($c_amount);
        $amount_money->setCurrency(setting('currency_code'));

        $body = new \Square\Models\CreatePaymentRequest(
            $userPaymentMethod['payment_method'],
            time().rand(1, 1000)
        );
        $body->setAmountMoney($amount_money);
        $body->setAutocomplete(true);
        $body->setCustomerId(auth()->user()->square_customer_id);
        $body->setNote('Order Payment');

        $api_response = $client->getPaymentsApi()->createPayment($body);

        // $amount=$amount/100;
        // $c_amount=$amount;
        // $credit_exchange_rate=setting('credit_exchange_rate');
        // $amount=$amount/$credit_exchange_rate;

        if ($api_response->isSuccess()) {
            $result = $api_response->getResult();
            $result=json_decode(json_encode($result), true);

            $transaction = new Transaction;
            $transaction->user_id = auth()->user()->id;
            $transaction->amount = $amount;
            $transaction->wallet_balance = auth()->user()->wallet_balance+$amount;
            $transaction->status = 1;
            $transaction->currency_amount = $c_amount;
            $transaction->payment_method = 'Card';
            $transaction->type = 'Cr';
            $transaction->comment = 'Wallet Recharge';
            $transaction->transaction_json =json_encode($result);
            $transaction->online_transaction_id =$result['payment']['id'];
            $transaction->save();

            $user = User::find(auth()->user()->id);
            $user->wallet_balance = $transaction->wallet_balance;
            $user->save();
            event(new WalletRecharge($user, $transaction));
            Session::flash('success', 'Payment has been successfully processed.');
            if ($order_id) {
                $transaction = new Transaction;
                $transaction->user_id = auth()->user()->id;
                $transaction->amount = $amount;
                $transaction->wallet_balance = auth()->user()->wallet_balance-$amount;
                $transaction->status = 1;
                $transaction->type = 'Dr';
                $transaction->payment_method = 'Scribe Credit';
                $transaction->comment = 'Order (#'.$order_id.') Payment';
                $transaction->transaction_json =json_encode([]);
                $transaction->currency_amount =0;
                $transaction->save();

                $order = Order::find($order_id);
                $order->status = 'pending';
                $order->transaction_id = $transaction->id;
                $order->save();
            }
        } else {
            $errors = $api_response->getErrors();
            $result=json_decode(json_encode($errors), true);
            $transaction = new Transaction;
            $transaction->user_id = auth()->user()->id;
            $transaction->amount = $amount;
            $transaction->wallet_balance = auth()->user()->wallet_balance;
            $transaction->status = 0;
            $transaction->currency_amount = $c_amount;
            $transaction->payment_method = 'Card';
            $transaction->type = 'Cr';
            $transaction->comment = 'Wallet Recharge Failed.'.$result[0]['detail'];
            $transaction->transaction_json =json_encode($result);
            $transaction->online_transaction_id ='';
            $transaction->save();
            Session::flash('error', 'Payment failed.'.$result[0]['detail']);
        }
        return json_decode(json_encode($result), true);
    }
}


if (! function_exists('format_money')) {
    /**
     * Helper to grab the application name.
     *
     * @return mixed
     */
    function format_money($money)
    {
        return number_format($money, 2, '.', '');
    }
}

if (! function_exists('status_format')) {
    /**
     * Helper to grab the application name.
     *
     * @return mixed
     */
    function status_format($status_key)
    {
        $status=status_list();

        return $status[$status_key];
    }
}

if (! function_exists('status_list')) {
    /**
     * Helper to grab the application name.
     *
     * @return mixed
     */
    function status_list()
    {
        $status_list=['pending'=>'In Production: Will send in 24-48 hours','processing'=>'Approved & Submitted','payment-pending'=>'Payment Pending','printing'=>'','shipped'=>'','delivered'=>'Complete: Sent Via USPS','pending-pickup'=>'','picked'=>'','draft'=>'Draft','on-going'=>'','paused'=>'Paused','delete'=>''];

        return $status_list;
    }
}


/*
 * Global helpers file with misc functions.
 */
if (! function_exists('user_registration')) {
    /**
     * Helper to grab the application name.
     *
     * @return mixed
     */
    function user_registration()
    {
        $user_registration = false;

        if (env('USER_REGISTRATION') == 'true') {
            $user_registration = true;
        }

        return $user_registration;
    }
}

/*
 *
 * label_case
 *
 * ------------------------------------------------------------------------
 */
if (! function_exists('label_case')) {
    /**
     * Prepare the Column Name for Lables.
     */
    function label_case($text)
    {
        $order = ['_', '-'];
        $replace = ' ';

        $new_text = trim(\Illuminate\Support\Str::title(str_replace('"', '', $text)));
        $new_text = trim(\Illuminate\Support\Str::title(str_replace($order, $replace, $text)));
        $new_text = preg_replace('!\s+!', ' ', $new_text);

        return $new_text;
    }
}

/*
 *
 * show_column_value
 *
 * ------------------------------------------------------------------------
 */
if (! function_exists('show_column_value')) {
    /**
     * Return Column values as Raw and formatted.
     *
     * @param  string  $valueObject  Model Object
     * @param  string  $column  Column Name
     * @param  string  $return_format  Return Type
     * @return string Raw/Formatted Column Value
     */
    function show_column_value($valueObject, $column, $return_format = '')
    {
        $column_name = $column->Field;
        $column_type = $column->Type;

        $value = $valueObject->$column_name;

        if ($return_format == 'raw') {
            return $value;
        }

        if (($column_type == 'date') && $value != '') {
            $datetime = \Carbon\Carbon::parse($value);

            return $datetime->isoFormat('LL');
        } elseif (($column_type == 'datetime' || $column_type == 'timestamp') && $value != '') {
            $datetime = \Carbon\Carbon::parse($value);

            return $datetime->isoFormat('LLLL');
        } elseif ($column_type == 'json') {
            $return_text = json_encode($value);
        } elseif ($column_type != 'json' && \Illuminate\Support\Str::endsWith(strtolower($value), ['png', 'jpg', 'jpeg', 'gif', 'svg'])) {
            $img_path = asset($value);

            $return_text = '<figure class="figure">
                                <a href="'.$img_path.'" data-lightbox="image-set" data-title="Path: '.$value.'">
                                    <img src="'.$img_path.'" style="max-width:200px;" class="figure-img img-fluid rounded img-thumbnail" alt="">
                                </a>
                                <figcaption class="figure-caption">Path: '.$value.'</figcaption>
                            </figure>';
        } else {
            $return_text = $value;
        }

        return $return_text;
    }
}

/*
 *
 * fielf_required
 * Show a * if field is required
 *
 * ------------------------------------------------------------------------
 */
if (! function_exists('fielf_required')) {
    /**
     * Prepare the Column Name for Lables.
     */
    function fielf_required($required)
    {
        $return_text = '';

        if ($required != '') {
            $return_text = '<span class="text-danger">*</span>';
        }

        return $return_text;
    }
}

/*
 * Get or Set the Settings Values
 *
 * @var [type]
 */
if (! function_exists('setting')) {
    function setting($key, $default = null)
    {
        if (is_null($key)) {
            return new App\Models\Setting();
        }

        if (is_array($key)) {
            return App\Models\Setting::set($key[0], $key[1]);
        }

        $value = App\Models\Setting::get($key);

        return is_null($value) ? value($default) : $value;
    }
}

/*
 * Show Human readable file size
 *
 * @var [type]
 */
if (! function_exists('humanFilesize')) {
    function humanFilesize($size, $precision = 2)
    {
        $units = ['B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        $step = 1024;
        $i = 0;

        while (($size / $step) > 0.9) {
            $size = $size / $step;
            $i++;
        }

        return round($size, $precision).$units[$i];
    }
}

/*
 *
 * Encode Id to a Hashids\Hashids
 *
 * ------------------------------------------------------------------------
 */
if (! function_exists('encode_id')) {
    /**
     * Prepare the Column Name for Lables.
     */
    function encode_id($id)
    {
        $hashids = new Hashids\Hashids(config('app.salt'), 3, 'abcdefghijklmnopqrstuvwxyz1234567890');
        $hashid = $hashids->encode($id);

        return $hashid;
    }
}

/*
 *
 * Decode Id to a Hashids\Hashids
 *
 * ------------------------------------------------------------------------
 */
if (! function_exists('decode_id')) {
    /**
     * Prepare the Column Name for Lables.
     */
    function decode_id($hashid)
    {
        $hashids = new Hashids\Hashids(config('app.salt'), 3, 'abcdefghijklmnopqrstuvwxyz1234567890');
        $id = $hashids->decode($hashid);

        if (count($id)) {
            return $id[0];
        } else {
            abort(404);
        }
    }
}

/*
 *
 * Prepare a Slug for a given string
 * Laravel default str_slug does not work for Unicode
 *
 * ------------------------------------------------------------------------
 */
if (! function_exists('slug_format')) {
    /**
     * Format a string to Slug.
     */
    function slug_format($string)
    {
        $base_string = $string;

        $string = preg_replace('/\s+/u', '-', trim($string));
        $string = str_replace('/', '-', $string);
        $string = str_replace('\\', '-', $string);
        $string = strtolower($string);

        $slug_string = $string;

        return $slug_string;
    }
}

/*
 *
 * icon
 * A short and easy way to show icon fornts
 * Default value will be check icon from FontAwesome
 *
 * ------------------------------------------------------------------------
 */
if (! function_exists('icon')) {
    /**
     * Format a string to Slug.
     */
    function icon($string = 'fas fa-check')
    {
        $return_string = "<i class='".$string."'></i>";

        return $return_string;
    }
}

/*
 *
 * logUserAccess
 * Get current user's `name` and `id` and
 * log as debug data. Additional text can be added too.
 *
 * ------------------------------------------------------------------------
 */
if (! function_exists('logUserAccess')) {
    /**
     * Format a string to Slug.
     */
    function logUserAccess($text = '')
    {
        $auth_text = '';

        if (\Auth::check()) {
            $auth_text = 'User:'.\Auth::user()->name.' (ID:'.\Auth::user()->id.')';
        }

        \Log::debug(label_case($text)." | $auth_text");
    }
}

/*
 *
 * bn2enNumber
 * Convert a Bengali number to English
 *
 * ------------------------------------------------------------------------
 */
if (! function_exists('bn2enNumber')) {
    /**
     * Prepare the Column Name for Lables.
     */
    function bn2enNumber($number)
    {
        $search_array = ['১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯', '০'];
        $replace_array = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0'];

        $en_number = str_replace($search_array, $replace_array, $number);

        return $en_number;
    }
}

/*
 *
 * bn2enNumber
 * Convert a English number to Bengali
 *
 * ------------------------------------------------------------------------
 */
if (! function_exists('en2bnNumber')) {
    /**
     * Prepare the Column Name for Lables.
     */
    function en2bnNumber($number)
    {
        $search_array = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0'];
        $replace_array = ['১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯', '০'];

        $bn_number = str_replace($search_array, $replace_array, $number);

        return $bn_number;
    }
}

/*
 *
 * bn2enNumber
 * Convert a English number to Bengali
 *
 * ------------------------------------------------------------------------
 */
if (! function_exists('en2bnDate')) {
    /**
     * Convert a English number to Bengali.
     */
    function en2bnDate($date)
    {
        // Convert numbers
        $search_array = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0'];
        $replace_array = ['১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯', '০'];
        $bn_date = str_replace($search_array, $replace_array, $date);

        // Convert Short Week Day Names
        $search_array = ['Fri', 'Sat', 'Sun', 'Mon', 'Tue', 'Wed', 'Thu'];
        $replace_array = ['শুক্র', 'শনি', 'রবি', 'সোম', 'মঙ্গল', 'বুধ', 'বৃহঃ'];
        $bn_date = str_replace($search_array, $replace_array, $bn_date);

        // Convert Month Names
        $search_array = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $replace_array = ['জানুয়ারী', 'ফেব্রুয়ারী', 'মার্চ', 'এপ্রিল', 'মে', 'জুন', 'জুলাই', 'আগষ্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর'];
        $bn_date = str_replace($search_array, $replace_array, $bn_date);

        // Convert Short Month Names
        $search_array = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $replace_array = ['জানুয়ারী', 'ফেব্রুয়ারী', 'মার্চ', 'এপ্রিল', 'মে', 'জুন', 'জুলাই', 'আগষ্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর'];
        $bn_date = str_replace($search_array, $replace_array, $bn_date);

        // Convert AM-PM
        $search_array = ['am', 'pm', 'AM', 'PM'];
        $replace_array = ['পূর্বাহ্ন', 'অপরাহ্ন', 'পূর্বাহ্ন', 'অপরাহ্ন'];
        $bn_date = str_replace($search_array, $replace_array, $bn_date);

        return $bn_date;
    }
}

/*
 *
 * banglaDate
 * Get the Date of Bengali Calendar from the Gregorian Calendar
 * By default is will return the Today's Date
 *
 * ------------------------------------------------------------------------
 */
if (! function_exists('banglaDate')) {
    function banglaDate($date_input = '')
    {
        if ($date_input == '') {
            $date_input = date('Y-m-d');
        }

        $date_input = strtotime($date_input);

        $en_day = date('d', $date_input);
        $en_month = date('m', $date_input);
        $en_year = date('Y', $date_input);

        $bn_month_days = [30, 30, 30, 30, 31, 31, 31, 31, 31, 31, 29, 30];
        $bn_month_middate = [13, 12, 14, 13, 14, 14, 15, 15, 15, 16, 14, 14];
        $bn_months = ['পৌষ', 'মাঘ', 'ফাল্গুন', 'চৈত্র', 'বৈশাখ', 'জ্যৈষ্ঠ', 'আষাঢ়', 'শ্রাবণ', 'ভাদ্র', 'আশ্বিন', 'কার্তিক', 'অগ্রহায়ণ'];

        // Day & Month
        if ($en_day <= $bn_month_middate[$en_month - 1]) {
            $bn_day = $en_day + $bn_month_days[$en_month - 1] - $bn_month_middate[$en_month - 1];
            $bn_month = $bn_months[$en_month - 1];

            // Leap Year
            if (($en_year % 400 == 0 || ($en_year % 100 != 0 && $en_year % 4 == 0)) && $en_month == 3) {
                $bn_day += 1;
            }
        } else {
            $bn_day = $en_day - $bn_month_middate[$en_month - 1];
            $bn_month = $bn_months[$en_month % 12];
        }

        // Year
        $bn_year = $en_year - 593;
        if (($en_year < 4) || (($en_year == 4) && (($en_day < 14) || ($en_day == 14)))) {
            $bn_year -= 1;
        }

        $return_bn_date = $bn_day.' '.$bn_month.' '.$bn_year;
        $return_bn_date = en2bnNumber($return_bn_date);

        return $return_bn_date;
    }
}

/*
 *
 * Decode Id to a Hashids\Hashids
 *
 * ------------------------------------------------------------------------
 */
if (! function_exists('generate_rgb_code')) {
    /**
     * Prepare the Column Name for Lables.
     */
    function generate_rgb_code($opacity = '0.9')
    {
        $str = '';
        for ($i = 1; $i <= 3; $i++) {
            $num = mt_rand(0, 255);
            $str .= "$num,";
        }
        $str .= "$opacity,";
        $str = substr($str, 0, -1);

        return $str;
    }
}

/*
 *
 * Return Date with weekday
 *
 * ------------------------------------------------------------------------
 */
if (! function_exists('date_today')) {
    /**
     * Return Date with weekday.
     *
     * Carbon Locale will be considered here
     * Example:
     * শুক্রবার, ২৪ জুলাই ২০২০
     * Friday, July 24, 2020
     */
    function date_today()
    {
        $str = \Carbon\Carbon::now()->isoFormat('dddd, LL');

        return $str;
    }
}

if (! function_exists('language_direction')) {
    /**
     * return direction of languages.
     *
     * @return string
     */
    function language_direction($language = null)
    {
        if (empty($language)) {
            $language = app()->getLocale();
        }
        $language = strtolower(substr($language, 0, 2));
        $rtlLanguages = [
            'ar', //  'العربية', Arabic
            'arc', //  'ܐܪܡܝܐ', Aramaic
            'bcc', //  'بلوچی مکرانی', Southern Balochi
            'bqi', //  'بختياري', Bakthiari
            'ckb', //  'Soranî / کوردی', Sorani Kurdish
            'dv', //  'ދިވެހިބަސް', Dhivehi
            'fa', //  'فارسی', Persian
            'glk', //  'گیلکی', Gilaki
            'he', //  'עברית', Hebrew
            'lrc', //- 'لوری', Northern Luri
            'mzn', //  'مازِرونی', Mazanderani
            'pnb', //  'پنجابی', Western Punjabi
            'ps', //  'پښتو', Pashto
            'sd', //  'سنڌي', Sindhi
            'ug', //  'Uyghurche / ئۇيغۇرچە', Uyghur
            'ur', //  'اردو', Urdu
            'yi', //  'ייִדיש', Yiddish
        ];
        if (in_array($language, $rtlLanguages)) {
            return 'rtl';
        }

        return 'ltr';
    }
}
// if (! function_exists('trim_spec')) {
//     function trim_spec($name){
//         return str_replace(';', '', str_replace(')', '', str_replace('(', '', $name)));
//     }
// }
if (! function_exists('read_excel_data')) {
    /**
     * return direction of languages.
     *
     * @return string
     */
    function read_excel_data($the_file, $load_type=0)
    {
        try {
            if ($load_type) {
                $spreadsheet = IOFactory::load(public_path('storage/'.$the_file));
            } else {
                $spreadsheet = IOFactory::load($the_file->getRealPath());
            }
            $sheet        = $spreadsheet->getActiveSheet();
            $row_limit    = $sheet->getHighestDataRow();
            $column_limit = $sheet->getHighestDataColumn();
            $row_range    = range(2, $row_limit);
            
            if($row_limit<=1){
                $row_range=[];
            }

            for ($i = 'A'; $i !== $column_limit; $i++){
                $column_range[]=$i;
            }
            $column_range[]=$column_limit;
            $startcount = 2;
            $data = array();
            $header = array();
            foreach ($column_range as $column) {
                if(!empty($sheet->getCell($column.'1')->getValue())){
                    $header[$column]=trim_spec($sheet->getCell($column.'1')->getValue());
                }
            }

            foreach ($row_range as $row) {
                foreach ($column_range as $column) {
                    if(isset($header[$column])){
                        $data[$startcount][$header[$column]]=$sheet->getCell($column. $row)->getValue();
                    }
                }
                $startcount++;
            }
            $error_code=0;
        } catch (Exception $e) {
            $error_code = $e->errorInfo[1];
        }
        return ['error_code'=>$error_code,'data'=>$data,'header'=>$header];
    }
}

if (! function_exists('credit_exchange_rate')) {
    /**
     * return direction of languages.
     *
     * @return string
     */
    function credit_exchange_rate($card_count=1)
    {
        return setting('credit_exchange_rate')*$card_count;
    }
}

if (! function_exists('per_credit_price')) {
    /**
     * return direction of languages.
     *
     * @return string
     */
    function per_credit_price($row_count)
    {
        switch ($row_count) {
            case $row_count <= 100:
                $price=setting('card_written_pricing_less_then_equal_to_100');
                break;
            case $row_count > 100 && 500 >= $row_count:
                $price=setting('card_written_pricing_101_to_500');
                break;
            case $row_count > 500 && 1000 >= $row_count:
                $price=setting('card_written_pricing_501_to_1000');
                break;
            case $row_count > 1000 && 2000 >= $row_count:
                $price=setting('card_written_pricing_1001_to_2000');
                break;
            case $row_count > 2000:
                $price=setting('card_written_pricing_greater_2000');
                break;
            default:
                $price=setting('card_written_pricing_less_then_equal_to_100');
        }
        return $price;
    }
}

if (! function_exists('order_total')) {
    /**
     * return direction of languages.
     *
     * @return string
     */
    function order_total($row_count)
    {
        switch ($row_count) {
            case $row_count <= 100:
                $price=setting('card_written_pricing_less_then_equal_to_100');
                break;
            case $row_count > 100 && 500 <= $row_count:
                $price=setting('card_written_pricing_101_to_500');
                break;
            case $row_count > 500 && 1000 <= $row_count:
                $price=setting('card_written_pricing_501_to_1000');
                break;
            case $row_count > 1000 && 2000 <= $row_count:
                $price=setting('card_written_pricing_1001_to_2000');
                break;
            case $row_count > 2000:
                $price=setting('card_written_pricing_greater_2000');
                break;
            default:
                $price=setting('card_written_pricing_less_then_equal_to_100');
        }
        return $price*$row_count;
    }
}

if (! function_exists('trim_spec')) {
    function trim_spec($name){
        return strtoupper(str_replace(' ', '_',stripslashes(str_replace(';', '', str_replace(')', '', str_replace('(', '',preg_replace('~\/~','',$name)))))));
    }
}


if (! function_exists('save_payment')) {
    /**
     * return direction of languages.
     *
     * @return string
     */
    function save_payment($request)
    {
        $stripe = new \Stripe\StripeClient(
            env('STRIPE_SECRET')
        );
        $payment=$stripe->paymentIntents->retrieve(
            $request->get('payment_intent'),
            []
        );
        $status=0;
        if ($payment['status']=='succeeded') {
            $amount=$payment['amount']/100;
            $c_amount=$payment['amount']/100;
            $credit_exchange_rate=setting('credit_exchange_rate');
            $amount=$amount/$credit_exchange_rate;
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
            $status=1;

            $cards = $stripe->paymentMethods->all(['customer' =>auth()->user()->stripe_customer_id, 'type' => 'card']);

            if (isset($cards['data']) && count($cards['data']) > 0) {
                foreach ($cards['data'] as $k => $v) {
                    if ($v['id'] == $payment['payment_method']) {
                        $card_type = $v['card']['brand'];
                        $last_4_digits = $v['card']['last4'];
                        $expiry_date = sprintf("%02d", $v['card']['exp_month'])."/".substr($v['card']['exp_year'], -2);
                        break;
                    }
                }
            }

            UserPaymentMethod::firstOrCreate(
                ['user_id' => auth()->user()->id,'pm_user_id'=>auth()->user()->stripe_customer_id,'payment_method'=>$payment['payment_method']],
                ['status' => '1','card_type' => $card_type,'last_4_digits' => $last_4_digits,'expiry_date' => $expiry_date]
            );

            event(new WalletRecharge($user, $transaction));
        }
        return $status;
    }
}
if (! function_exists('curl_url_hit')) {
    function curl_url_hit($url)
    {
        $cmd  = "curl --max-time 60 ";
        $cmd .= "'" . $url . "'";
        $cmd .= " > /dev/null 2>&1 &";
        exec($cmd, $output, $exit);
        return $exit == 0;
    }
}
if (! function_exists('create_copy_excel')) {
    function create_copy_excel($order_id)
    {
        try {
            $order = Order::where('id', $order_id)->first();
            $order_json=read_excel_data($order->uploaded_recipient_file, 1);
            $order_json_1=json_decode($order->order_json, true);

            $spreadsheet = IOFactory::load(public_path('storage/'.$order->uploaded_recipient_file));
            $sheet = $spreadsheet->getActiveSheet();
            $row_limit    = $sheet->getHighestDataRow();
            $column_limit = $sheet->getHighestDataColumn();
            $next_column = ++$column_limit;
            $row_range    = range(2, $row_limit);

            $sheet->setCellValue($next_column.'1', 'FINAL_PRINTING_MESSAGE');

            foreach ($row_range as $row) {
                if (isset($order_json['data'][$row])) {
                    $final_message=final_message($order_json['data'][$row], $order_json_1['hwl_custom_msg'], $order_json_1['system_property_1']);
                    $sheet->setCellValue($next_column.$row, $final_message);
                }
            }
            $file_name = $order_id."_".date("Y-m-d")."_".date("H:i:s")."_".count($order_json['data']).".xlsx";
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
            $writer->save(public_path('storage/'.$file_name));
            $order->final_printing_file=$file_name;
            $order->save();
        } catch (Exception $e) {
        }
    }
}
if (! function_exists('final_message')) {
    function final_message($data, $message,$mapping_fields=[],$action=0)
    {
        
        foreach ($mapping_fields as $key => $value) {
            if($action){
                $preview_array['/\b'.$key.'\b/']=isset($mapping_fields[$key])?isset($data[$mapping_fields[$key]])?trim($data[$mapping_fields[$key]]):$mapping_fields[$key]:'';
            }else{
                $preview_array['/\b'.$key.'\b/']=isset($mapping_fields[$key])?isset($data[$mapping_fields[$key]])?trim($data[$mapping_fields[$key]]):'':'';
            }
        }
        $final_message = isset($preview_array)?preg_replace(array_keys($preview_array), array_values($preview_array), $message):$message;
        $final_message = str_replace('&ensp;','  ',  $final_message);
        $final_message = str_replace("\t", '       ', $final_message);
        $final_message = str_replace('     ','   ',  $final_message);
        $final_message = preg_replace( '/[\x{200B}-\x{200D}\x{FEFF}]/u', '', $final_message );
        return str_replace(array( '{', '}' ), '', $final_message);
    }
}
if (! function_exists('auto_create_order')) {
    function auto_create_order()
    {
        $master_file_record_limit = setting('master_file_record_limit');
        $orders = Order::where('campaign_type', 'on-going')->where('status', 'pending')->get();
        foreach ($orders as $key => $value) {
            $loop=1;
            $total_pending=$create_order=($value->listing->contacts->count()-$value['threshold_order_created']);
            if($create_order>$master_file_record_limit){
                $loop=ceil($create_order/$master_file_record_limit);
                $create_order=$master_file_record_limit;
                $total_pending=$total_pending-$create_order;
            }
            if ($value['schedule_date']<date("Y-m-d H:i:s")&&$create_order>0) {
                for ($x = 1; $x <= $loop; $x+=1) {
                    create_order_from_ongoing_order($value->id, $create_order);
                    if($total_pending>$master_file_record_limit){
                        $create_order=$master_file_record_limit;
                        $total_pending=$total_pending-$master_file_record_limit;
                    }else{
                        $create_order=$total_pending;
                        $total_pending=0;
                    }
                }
            }
        }
    }
}
if (! function_exists('create_order_from_ongoing_order')) {
    function create_order_from_ongoing_order($order_id, $card_to_order=0)
    {
        $ongoing_order=Order::find($order_id);
        $batch_order=Order::where('parent_order_id', $order_id)->count();
        $batch=$batch_order+1;
        $order_amount=$card_to_order*credit_exchange_rate();
        $user=User::find($ongoing_order['user_id']);
        $listing=Listing::find($ongoing_order['listing_id']);
        $contact_ids=$meta_data=[];
        $contacts=Contact::where(['listing_id'=>$ongoing_order['listing_id']])->skip($ongoing_order['threshold_order_created'])->take($card_to_order)->get();
        foreach ($contacts as $key => $value) {
            $contact_ids[]=$value->id;
        }
        if($contact_ids){
            $meta = MetaData::whereIn('meta_id', $contact_ids)->get();
            $meta_data=[];
            foreach ($meta as $key => $value) {
                $meta_data[$value['meta_id']][$value['meta_key']]=$value['meta_value'];
            }
        }
        if($ongoing_order['payment_method_id']){
            $card_data = UserPaymentMethod::where(['id'=>$ongoing_order['payment_method_id']])->first();
        }else{
            $card_data = UserPaymentMethod::where(['is_default'=>1,'user_id'=>$ongoing_order['user_id']])->first();
        }

        if ($user->wallet_balance<$order_amount) {
            if ($ongoing_order['auto_charge']) {
                $recharge_amount=$order_amount-$user->wallet_balance;
                create_square_payment($recharge_amount, $card_data->id);
                $user=User::find($ongoing_order['user_id']);
            } else {
                $ongoing_order->status = 'paused';
                $ongoing_order->save();
                return true;
            }
        }

        $transaction = new Transaction;
        $transaction->user_id = $ongoing_order['user_id'];
        $transaction->amount = $order_amount;
        $transaction->wallet_balance = $user->wallet_balance-$transaction->amount;
        $transaction->status = 1;
        $transaction->type = 'Dr';
        $transaction->payment_method = 'Scribe Credit';
        $transaction->comment = 'Order  Payment';
        $transaction->transaction_json =json_encode($ongoing_order);
        $transaction->currency_amount =0;
        $transaction->save();

        $order_json=json_decode($ongoing_order['order_json'], 1);
        $order_json['total_recipient']=$card_to_order;
        $order = new Order;
        $order->user_id = $ongoing_order['user_id'];
        $order->order_amount= $order_amount;
        $order->status= 'pending';
        $order->campaign_name= $ongoing_order['campaign_name']." B".$batch;
        $order->campaign_type= 'one-time';
        $order->campaign_message= $ongoing_order['campaign_message'];
        $order->campaign_type_2= 'One-time';
        $order->front_design= $ongoing_order['front_design'];
        $order->back_design= $ongoing_order['back_design'];
        $order->main_design= $ongoing_order['main_design'];
        $order->inner_design= $ongoing_order['inner_design'];
        $order->schedule_status= 0;
        $order->exclude_mf= $ongoing_order['exclude_mf'];
        $order->auto_charge= 0;
        $order->threshold= 0;
        $order->uploaded_recipient_file='';
        $order->parent_order_id=$order_id;
        $order->final_printing_file= '';
        $order->order_json= json_encode($order_json);
        $order->transaction_id = $transaction->id;
        $order->return_address_id = $ongoing_order['return_address_id']?$ongoing_order['return_address_id']:0;
        $order->save();

        $user = User::find($ongoing_order['user_id']);
        $user->wallet_balance = $transaction->wallet_balance;
        $user->save();

        $transaction = Transaction::find($transaction->id);
        $transaction->order_id = $order->id;
        $transaction->comment = 'Order #'.$order->id.' Payment';
        $transaction->save();


        $list = new Listing;
        $list->user_id = $ongoing_order['user_id'];
        $list->name = $listing['name']." B".$batch;
        $list->status = 'active';
        $list->save();
        $list_id=$list->id;


        $ongoing_order->threshold_order_created = $ongoing_order->threshold_order_created+$card_to_order;
        $ongoing_order->save();

        foreach ($contacts as $key => $value) {
            $save_multiple_array=[];
            $value_w=$value->toArray();
            $meta_id=$value_w['id'];
            unset($value_w['id']);
            $value_w['listing_id']=$list_id;
            $contact=Contact::create($value_w);
            if(isset($meta_data[$meta_id])){
                foreach ($meta_data[$meta_id] as $key1 => $value1) {
                    if (!in_array($key, ['first_name','last_name','company_name','contact_email','phone','address','city','state','zip','listing_id','email','password','list_name','message'])) {
                        $save_multiple_array[]=[
                            'listing_id' => $list_id,
                            'order_id' => $order->id,
                            'meta_id' => $contact->id,
                            'type' => 'contact',
                            'meta_key' => $key1,
                            'meta_value' => $value1
                        ];
                    }
                }
            }
            if($save_multiple_array){
                MetaData::insert($save_multiple_array);
            }
        }


        $order = Order::find($order->id);
        $order->listing_id = $list_id;
        $order->save();

        create_copy_excel_from_listing_id($list_id);
        create_copy_excel($order->id);
        event(new OrderPlaced($user, $order));
    }
}

if (! function_exists('create_copy_excel_from_listing_id')) {
    function create_copy_excel_from_listing_id($listing_id)
    {
        try {
            $list = Listing::where('id', $listing_id)->first();
            $contacts = Contact::where('listing_id', $listing_id)->get();
            $meta = MetaData::where('listing_id', $listing_id)->get();
            $meta_data=[];
            foreach ($meta as $key => $value) {
                $meta_data[$value['meta_id']][$value['meta_key']]=$value['meta_value'];
            }
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $sheet->setCellValue('A1', strtoupper('first_name'));
            $sheet->setCellValue('B1', strtoupper('last_name'));
            $sheet->setCellValue('C1', strtoupper('email'));
            $sheet->setCellValue('D1', strtoupper('company_name'));
            $sheet->setCellValue('E1', strtoupper('phone'));
            $sheet->setCellValue('F1', strtoupper('address'));
            $sheet->setCellValue('G1', strtoupper('city'));
            $sheet->setCellValue('H1', strtoupper('state'));
            $sheet->setCellValue('I1', strtoupper('zip'));

            $i=2;
            $meta_columns=[];
            foreach ($contacts as $key=>$row) {
                $sheet->setCellValue('A'.$i, $row->first_name);
                $sheet->setCellValue('B'.$i, $row->last_name);
                $sheet->setCellValue('C'.$i, $row->email);
                $sheet->setCellValue('D'.$i, $row->company_name);
                $sheet->setCellValue('E'.$i, $row->phone);
                $sheet->setCellValue('F'.$i, $row->address);
                $sheet->setCellValue('G'.$i, $row->city);
                $sheet->setCellValue('H'.$i, $row->state);
                $sheet->setCellValue('I'.$i, $row->zip);
                $next_column='J';
                if(isset($meta_data[$row->id])){
                    foreach ($meta_data[$row->id] as $key => $value) {
                        $sheet->setCellValue($next_column.$i, $value);
                        $next_column = ++$next_column;
                        $meta_columns[$key]=$key;
                    }
                }
                $i++;
            }
            $next_column='J';
            foreach ($meta_columns as $key1 => $value1) {
                $sheet->setCellValue($next_column.'1', strtoupper($value1));
                $next_column = ++$next_column;
            }

            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
            $file_name='uploaded_recipient_file_'.time().'.xlsx';
            $writer->save(public_path('storage/'.$file_name));
            $list->uploaded_recipient_file=$file_name;
            $list->save();
            Order::where('listing_id', $listing_id)->update(['uploaded_recipient_file'=>$file_name]);
            return['file_name'=>$file_name,'name'=>$list->name,'rows'=>count($contacts)];
        } catch (Exception $e) {
        }
    }
}
if (! function_exists('export_file_from_list_id')) {
    function export_file_from_list_id($listing_id)
    {
        try {
            $list = Listing::where('id', $listing_id)->first();
            $contacts = Contact::where('listing_id', $listing_id)->get();
            $meta = MetaData::where('listing_id', $listing_id)->get();
            $meta_data=[];
            foreach ($meta as $key => $value) {
                $meta_data[$value['meta_id']][$value['meta_key']]=$value['meta_value'];
            }
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $sheet->setCellValue('A1', strtoupper('id'));
            $sheet->setCellValue('B1', strtoupper('first_name'));
            $sheet->setCellValue('C1', strtoupper('last_name'));
            $sheet->setCellValue('D1', strtoupper('email'));
            $sheet->setCellValue('E1', strtoupper('company_name'));
            $sheet->setCellValue('F1', strtoupper('phone'));
            $sheet->setCellValue('G1', strtoupper('address'));
            $sheet->setCellValue('H1', strtoupper('city'));
            $sheet->setCellValue('I1', strtoupper('state'));
            $sheet->setCellValue('J1', strtoupper('zip'));

            $i=2;
            $meta_columns=[];
            foreach ($contacts as $key=>$row) {
                $sheet->setCellValue('A'.$i, $row->id);
                $sheet->setCellValue('B'.$i, $row->first_name);
                $sheet->setCellValue('C'.$i, $row->last_name);
                $sheet->setCellValue('D'.$i, $row->email);
                $sheet->setCellValue('E'.$i, $row->company_name);
                $sheet->setCellValue('F'.$i, $row->phone);
                $sheet->setCellValue('G'.$i, $row->address);
                $sheet->setCellValue('H'.$i, $row->city);
                $sheet->setCellValue('I'.$i, $row->state);
                $sheet->setCellValue('J'.$i, $row->zip);
                $next_column='K';
                if(isset($meta_data[$row->id])){
                    foreach ($meta_data[$row->id] as $key => $value) {
                        $sheet->setCellValue($next_column.$i, $value);
                        $next_column = ++$next_column;
                        $meta_columns[$key]=$key;
                    }
                }
                $i++;
            }
            $next_column='K';
            foreach ($meta_columns as $key1 => $value1) {
                $sheet->setCellValue($next_column.'1', strtoupper($value1));
                $next_column = ++$next_column;
            }

            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
            $file_name=$list['name'].'_export_'.date("Y-m-d")."_".date("H:i:s").'.xlsx';
            $writer->save(public_path('storage/'.$file_name));
            return $file_name;
        } catch (Exception $e) {
        }
    }
}
// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
    //Page header

    public $design_file;

	public function __construct($design_file)
	{
        $this->design_file = $design_file;
		parent::__construct("P", PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	}

    public function Header() {
        // get the current page break margin
        $bMargin = $this->getBreakMargin();
        // get current auto-page-break mode
        $auto_page_break = $this->AutoPageBreak;
        // disable auto-page-break
        $this->SetAutoPageBreak(false, 0);
        // set bacground image
        if(@$this->design_file[$this->page-1]){
            $file_path=public_path("storage/".$this->design_file[$this->page-1]);
            $this->Image($file_path, 0, 0, 140, 204, '', '', '', false, 300, '', false, false, 0);
        }
        // restore auto-page-break status
        $this->SetAutoPageBreak($auto_page_break, $bMargin);
        // set the starting point for the page content
        $this->setPageMark();
    }
    public function Footer() 
    { 
        $this->SetY(-15); 
        $this->SetFont('helvetica', 'I', 8); 

    }
}

// create new PDF document

function convertImageToPdfAndMerge($outer_design_file,$inner_design_file,$file_name){
    $new_design_array=[];
    
    $u_inner_design_file=array_unique($inner_design_file);
    foreach($u_inner_design_file as $key => $value){
        $u_inner_design_file[$value]=convert75bottom($value);
    }
    foreach($outer_design_file as $key => $value){
        $new_design_array[]=$outer_design_file[$key];
        $new_design_array[]=$u_inner_design_file[$inner_design_file[$key]];
    }
    $file_name = str_replace(".xlsx", "",$file_name);
    // Create PDF instance
    $pdf = new MYPDF($new_design_array);
    foreach ($new_design_array as $key => $value) {
        $pdf->AddPage('P', array(140, 204));
    }
    if (ob_get_contents()) ob_end_clean();
    $outer_file_name="Design-File-".$file_name.".pdf";
    $pdf->Output(public_path("storage/".$outer_file_name), 'F'); // 'D' sends the file inline to the browser for download
    // Create PDF instance

    return ['outer_file_name'=>$outer_file_name,'inner_file_name'=>''];
}
if (! function_exists('create_excel_for_master_file')) {
    function create_excel_for_master_file($data,$master_id)
    {
        try {
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $sheet->setCellValue('A1', 'Campaign Name');
            $sheet->setCellValue('B1', 'Recipient First Name');
            $sheet->setCellValue('C1', 'Recipient Last Name');
            $sheet->setCellValue('D1', 'Recipient Company');
            $sheet->setCellValue('E1', 'Recipient Email');
            $sheet->setCellValue('F1', 'Recipient Phone');
            $sheet->setCellValue('G1', 'Recipient Address');
            $sheet->setCellValue('H1', 'Recipient City');
            $sheet->setCellValue('I1', 'Recipient State');
            $sheet->setCellValue('J1', 'Recipient Zip');
            $sheet->setCellValue('K1', 'Return First Name');
            $sheet->setCellValue('L1', 'Return Last Name');
            $sheet->setCellValue('M1', 'Return Street Address');
            $sheet->setCellValue('N1', 'Return City');
            $sheet->setCellValue('O1', 'Return Sate');
            $sheet->setCellValue('P1', 'Return Zip Code');
            $sheet->setCellValue('Q1', 'Outer Design');
            $sheet->setCellValue('R1', 'Inner Design');
            $sheet->setCellValue('S1', 'Custom Message ID');

            $latest_record=MasterFiles::find($master_id);

            $i=2;
            $meta_columns=[];
            foreach ($data as $key=>$row) {
                
                $list = new MasterFileMessage;
                $list->message = $row['final_message'];
                $list->inner_design = $row['inner_design_file'];
                $list->outer_design = $row['outer_design_file'];
                $list->master_file_id = $master_id;
                $list->save();
               
                $sheet->setCellValue('A'.$i, $row['order_name']);
                $sheet->setCellValue('B'.$i, $row['first_name']);
                $sheet->setCellValue('C'.$i, $row['last_name']);
                $sheet->setCellValue('D'.$i, $row['email']);
                $sheet->setCellValue('E'.$i, $row['company_name']);
                $sheet->setCellValue('F'.$i, $row['phone']);
                $sheet->setCellValue('G'.$i, $row['address']);
                $sheet->setCellValue('H'.$i, $row['city']);
                $sheet->setCellValue('I'.$i, $row['state']);
                $sheet->setCellValue('J'.$i, $row['zip']);
                $sheet->setCellValue('K'.$i, $row['return_first_name']);
                $sheet->setCellValue('L'.$i, $row['return_last_name']);
                $sheet->setCellValue('M'.$i, $row['return_address']);
                $sheet->setCellValue('N'.$i, $row['return_city']);
                $sheet->setCellValue('O'.$i, $row['return_state']);
                $sheet->setCellValue('P'.$i, $row['return_zip']);
                $sheet->setCellValue('Q'.$i, $row['outer_design']);
                $sheet->setCellValue('R'.$i, $row['inner_design']);
                $sheet->setCellValue('S'.$i, $list->id);
                $i++;
            }
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
            $file_name=$master_id.'_'.date("Y-m-d")."_".date("H:i:s")."_".count($data).'.xlsx';
            $writer->save(public_path('storage/'.$file_name));
            $latest_record->uploaded_recipient_file = trim($file_name);
            $latest_record->save();
            return ['file_name'=>$file_name];
        } catch (Exception $e) {
        }
    }
}
if (! function_exists('duplicateOrder')) {
    function duplicateOrder($id)
    {
        $order_detail=Order::find($id)->toArray();
        unset($order_detail['id']);
        unset($order_detail['transaction_id']);
        $order_detail['status']='payment-pending';
        $order_detail['campaign_name']=$order_detail['campaign_name']." Copy";
        if (auth()->user()->wallet_balance>=$order_detail['order_amount']) {
            $transaction = new Transaction;
            $transaction->user_id = auth()->user()->id;
            $transaction->amount = $order_detail['order_amount'];
            $transaction->wallet_balance = auth()->user()->wallet_balance-$order_detail['order_amount'];
            $transaction->status = 1;
            $transaction->type = 'Dr';
            $transaction->payment_method = 'Scribe Credit';
            $transaction->comment = 'Order Payment';
            $transaction->transaction_json =json_encode($order_detail);
            $transaction->currency_amount =0;
            $transaction->save();
            $order_detail['status']='pending';
            $order_detail['transaction_id']=$transaction->id;

            $user = User::find(auth()->user()->id);
            $user->wallet_balance = $transaction->wallet_balance;
            $user->save();
        }

        $order = Order::create($order_detail);

        if(isset($transaction)){
            $transaction = Transaction::find($transaction->id);
            $transaction->order_id = $order->id;
            $transaction->comment = 'Order #'.$order->id.' Payment';
            $transaction->save();
        }
        return $order->id;
    }
}

if (! function_exists('enevolopePreview')) {
    function enevolopePreview($data,$mapping_fields,$return_address=[])
    {
        $dummy_data=['FIRST_NAME'=>'Kiley','LAST_NAME'=>'Caldarera','ADDRESS'=>'25 E 75th St #69','CITY'=>'Los Angeles','STATE'=>'California','ZIP'=>'90034'];
        $message="{FIRST_NAME} {LAST_NAME}\r\n{ADDRESS}\r\n{CITY}, {STATE} {ZIP}";
        foreach ($mapping_fields as $key => $value) {
            $preview_array["{".$key."}"]=isset($data[$mapping_fields[$key]])&&!empty($data[$mapping_fields[$key]])?$data[$mapping_fields[$key]]:$dummy_data[$key];
        }

        $final_message = isset($preview_array)?preg_replace(array_keys($preview_array), array_values($preview_array), $message):$message;
        $final_message = str_replace(array( '{', '}' ), '', $final_message);
        if(empty($final_message)||strlen($final_message)=='12'){
            $final_message="Kiley Caldarera\r\n25 E 75th St #69\r\nLos Angeles, California 90034";
        }
        if($return_address){
            $final_message1=$return_address['full_name']."\r\n".$return_address['address']."\r\n".$return_address['city'].", ".$return_address['state']." ".$return_address['zip'];
        }else{
            $final_message1='';
        }
        

        array_map('unlink', glob(public_path('img/preview/'.auth()->user()->id."_enevolope_*")));
        $img = imagecreatefrompng(public_path('img/1500-with-shadow-final.png'));//replace with your image 
        $txt = str_replace('&zwnj;','',str_replace('&ensp;', '  ', strip_tags($final_message)));//your text
        $txt1 = str_replace('&zwnj;','',str_replace('&ensp;', '  ', strip_tags($final_message1)));//your text
        $fontFile = realpath(public_path('fonts/Lexi-Regular.ttf'));//replace with your font
        
        $font_weight=0;
        $fontSize = 30;
        $centerX = 550;
        
        $fontColor = imagecolorallocate($img, 255, 255, 255);
        $black = imagecolorallocate($img, 0, 0, 255);
        $angle = 0;
        $centerY = 500;

        //===================================
        $textbox = new Box($img);
        $textbox->setFontSize(40);
        $textbox->setFontFace($fontFile);
        $textbox->setFontColor(new Color(0, 0, 255)); // black
        $textbox->setBox(
            0,  // distance from left edge
            0,  // distance from top edge
            imagesx($img), // textbox width, equal to image width
            imagesy($img)  // textbox height, equal to image height
        );
        $textbox->setTextAlign('center', 'center');
        // it accepts multiline text
        $textbox->draw($txt);
        //===================================
        
       // imagettftext($img, $fontSize, $angle, $centerX, $centerY, $black, $fontFile, $txt, array("linespacing" => 0.45));
        if(env('APP_URL')=='https://scribenurture.com'){
            imagettftext($img, $fontSize, $angle,150,150, $black, $fontFile, $txt1, array("linespacing" => 0.45));
        }else{
            imagettftext($img, $fontSize, $angle,150,150, $black, $fontFile, $txt1, array("linespacing" => 1));
        }
        $image_name=auth()->user()->id."_enevolope_".time().rand().".png";
        imagesavealpha($img, true);
        imagepng($img,public_path('img/preview/'.$image_name));//save image
        imagedestroy($img);
        return $image_name;
    }
}

if (! function_exists('final_message_preview')) {
    function final_message_preview($data, $message,$mapping_fields=[])
    {
        foreach ($mapping_fields as $key => $value) {
            $preview_array['/\b'.$key.'\b/']=isset($mapping_fields[$key])?isset($data[$mapping_fields[$key]])&&!empty($data[$mapping_fields[$key]])?trim($data[$mapping_fields[$key]]):$key:$key;
        }
        $final_message = isset($preview_array)?preg_replace(array_keys($preview_array), array_values($preview_array), $message):$message;
        $final_message = str_replace('  ', '&ensp;', $final_message);
        return str_replace(array( '{', '}' ), '', $final_message);
    }
}

if (! function_exists('user_has_role')) {
    function user_has_role($id)
    {
        $ids = \DB::table('model_has_roles')->pluck('model_id')->toArray();
        if(in_array($id,$ids)){
            return 1;
        }
        return 0;
    }
}



if (! function_exists('contact_count')) {
    function contact_count($listing_id)
    {
        return Contact::where(['listing_id'=>$listing_id])->count();
    }
}

if (! function_exists('generate_design_Image')) {

    function generate_design_Image($type="front"){
        array_map('unlink', glob(public_path('img/preview/'.$type.'_'.auth()->user()->id."_*")));
       

        $front_design = imagecreatefrompng(public_path('img/'.$type.'_design.png'));
        $front = imagecreatefrompng(public_path('img/'.$type.'.png'));

        list($width, $height) = getimagesize(public_path('img/'.$type.'.png'));
        list($newwidth, $newheight) = getimagesize(public_path('img/'.$type.'_design.jpg'));
        $out = imagecreatetruecolor($newwidth, $newheight);
        imagecopyresampled($out, $front, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
        imagecopyresampled($out, $front_design, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
        $image_name=$type."_".auth()->user()->id."_".time().rand().".png";
        imagejpeg($out,public_path('img/preview/'.$image_name), 100);
        imagedestroy($out);
        return $image_name;
    }
}


if (! function_exists('generate_Preview_Image')) {

    function generate_Preview_Image($text,$message_length=''){
        array_map('unlink', glob(public_path('img/preview/'.auth()->user()->id."_*")));
        $img = imagecreatefrompng(public_path('img/Inside-1500-with-line.png'));//replace with your image 
        $lines = substr_count($text, "\n");
        $txt = str_replace('&zwnj;','',str_replace('&ensp;', '  ', strip_tags($text)));//your text
        $fontFile = realpath(public_path('fonts/Lexi-Regular.ttf'));//replace with your font
        if($message_length=='long'){
           $exp=explode( "\r\n", $txt);
        //    $text1=$exp[0]."\r\n".$exp[1]."\r\n".$exp[2];
        //    unset($exp[0]);
        //    unset($exp[1]);
        //    unset($exp[2]);
        //    foreach($exp as $k=>$v){
            
        //    }
          // array_splice($exp, 3, 0,["\r\n"]);
          array_splice($exp, 3, 0,[""]);
           $txt=implode("\r\n",$exp);
        }
        $font_weight=0;
        $fontSize = 36;
        $centerX = 140;
        
        switch ($lines) {
            // case 1:
            //     $fontSize -= 1;
            //     $centerX += 20;
            //     break;
            // case 2:
            //     $fontSize -= 1;
            //     $centerX += 20;
            //     break;
            // case 3:
            //     $fontSize -= 1;
            //     $centerX += 20;
            //     break;
            // case 4:
            //     $fontSize -= 1;
            //     $centerX += 20;
            //     break;
            // case 5:
            //     $fontSize -= 1;
            //     $centerX += 20;
            //     break;
            // case 6:
            //     $fontSize -= 1;
            //     $centerX += 20;
            //     break;
            // case 7:
            //     $fontSize -= 1;
            //     $centerX += 20;
            //     break;
            case 8:
                $fontSize -= 1;
                $centerX += 20;
                break;
            case 9:
                $fontSize -= 1;
                $centerX += 20;
                break;
            
            case 10:
                $fontSize -= 1;
                $centerX += 20;
                break;
            case 11:
                $fontSize -= 1;
                $centerX += 20;
                break;
            case 12:
                $fontSize -= 1;
                $centerX += 20;
                break;
            case 13:
                $fontSize -= 1;
                $centerX += 20;
                break;
            case 14:
                $fontSize -= 1;
                $centerX += 20;
              //  $font_weight=30;
                break;
            case 15:
                $fontSize -= 1;
                $centerX += 20;
            //    $font_weight=30;
                break;
            case 16:
                $fontSize -= 1;
                $centerX += 20;
                // $font_weight=30;
                break;
            case 17:
                $fontSize -= 1;
                $centerX += 20;
                // $font_weight=50;
                // $font_weight=30;
                break;
            case 18:
                $fontSize -= 1;
                $centerX += 20;
                // $font_weight=30;
                break;
            case 19:
                $fontSize -= 1;
                $centerX += 20;
                // $font_weight=30;
                break;
            case 20:
                $fontSize -= 1;
                $centerX += 20;
                // $font_weight=30;
                break;
        }


        // foreach(range(7,10) as $k=>$v){
        //     if(in_array($lines,range(7,10))){
        //         break;
        //     }
        //     $fontSize -= 1;
        //     $centerX += 20;

        //     if($v>=$lines){
        //         break;
        //     }
        // }

        // foreach(range(11,14) as $k=>$v){
        //     if(in_array($lines,range(11,14))){
        //         break;
        //     }
        //     $fontSize -= 1.5;
        //     $centerX += 25;

        //     if($v>=$lines){
        //         break;
        //     }
        // }

        // foreach(range(15,20) as $k=>$v){
        //     if($lines<15){
        //         break;
        //     }
        //     $fontSize -= 2;
        //     $centerX += 25;

        //     if($v>=$lines){
        //         break;
        //     }
        // }
        // foreach(range(22,26) as $k=>$v){
        //     if($lines<22){
        //         break;
        //     }
        //     $fontSize -= 2;
        //     $centerX += 25;

        //     if($v>=$lines){
        //         break;
        //     }
        // }
        $fontColor = imagecolorallocate($img, 255, 255, 255);
        $black = imagecolorallocate($img, 0, 0, 255);
        $angle = 0;
        $centerY = 1190;
        if($message_length=='long'){
            $centerY=$centerY-285;
            $centerY=$centerY+$font_weight;
            //imagettftext($img,$fontSize,$angle, $centerX,$centerY-450, $black, $fontFile,$text1, array("linespacing" => 0.45));
        }
        if(env('APP_URL')=='https://scribenurture.com'){
            imagettftext($img, $fontSize, $angle, $centerX, $centerY, $black, $fontFile, $txt, array("linespacing" => 0.45));
        }else{
            imagettftext($img, $fontSize, $angle, $centerX, $centerY, $black, $fontFile, $txt, array("linespacing" => 1));
        }
        $image_name=auth()->user()->id."_".time().rand().".png";
        imagesavealpha($img, true);
        imagepng($img,public_path('img/preview/'.$image_name));//save image
        imagedestroy($img);
        return $image_name;
    }
    function convert75bottom($image_path){
        if(!empty($image_path)){
            $inputImagePath = public_path("storage/".$image_path);

            // Load the image
            $image = imagecreatefrompng($inputImagePath);

            // Get image dimensions
            $width = imagesx($image);
            $height = imagesy($image);

            // Calculate the height of the bottom 75%
            $newHeightBottom = $height * 0.25;

            // Create a new image with the original width and the calculated height
            $newImage = imagecreatetruecolor($width, $height);

            // Fill the new image with white color
            $white = imagecolorallocate($newImage, 255, 255, 255);
            imagefill($newImage, 0, 0, $white);

            // Copy the top 25% of the original image to the new image
            imagecopy($newImage, $image, 0, 0, 0, 0, $width, $newHeightBottom);

            // Save or output the modified image
            $imp="card_design/inner_".time().rand(0,1000).".png";
            $outputImagePath = public_path("storage/".$imp);
            imagepng($newImage, $outputImagePath);

            // Free up memory
            imagedestroy($image);
            imagedestroy($newImage);

            return $imp;
        }
        return '';
    }
    function compress($source, $destination, $quality) {

        $info = getimagesize($source);
    
        if ($info['mime'] == 'image/jpeg') 
            $image = imagecreatefromjpeg($source);
    
        elseif ($info['mime'] == 'image/gif') 
            $image = imagecreatefromgif($source);
    
        elseif ($info['mime'] == 'image/png') 
            $image = imagecreatefrompng($source);
    
        imagejpeg($image, $destination, $quality);
    
        return $destination;
    }
    if (! function_exists('replace_message_id_with_message')) {
    function replace_message_id_with_message($master_id,$file_name)
    {
        $outer_design_files=[];
        $inner_design_files=[];
        try {
            $master_file = MasterFiles::where('id', $master_id)->first();
            $master_message_data = MasterFileMessage::where('master_file_id', $master_id)->pluck(
                'message', 
                'id'
              )->all();
            $outer_design_data = MasterFileMessage::where('master_file_id', $master_id)->pluck(
            'outer_design', 
            'id'
            )->all();
            $inner_design_data = MasterFileMessage::where('master_file_id', $master_id)->pluck(
            'inner_design', 
            'id'
            )->all();
            $order_json=read_excel_data($master_file->post_uploaded_recipient_file, 1);
            

            $spreadsheet = IOFactory::load(public_path('storage/'.$master_file->post_uploaded_recipient_file));
            $sheet = $spreadsheet->getActiveSheet();
            $row_limit    = $sheet->getHighestDataRow();
            $column_limit = $sheet->getHighestDataColumn();
            $next_column = 'S';

            for ($i = 'A'; $i !== $column_limit; $i++){
                $column_range[]=$i;
            }
            $column_range[]=$column_limit;

            foreach($column_range as $letter) {
                if($sheet->getCell($letter.'1')->getValue()=='Custom Message ID'){
                    $next_column=$letter;
                }
            }
            $row_range    = range(2, $row_limit);

            $sheet->setCellValue($next_column.'1', 'Custom Message');

            foreach ($row_range as $row) {
                $message_id=$sheet->getCell($next_column.$row)->getValue();
                if (isset($master_message_data[$message_id])) {
                    $sheet->setCellValue($next_column.$row, $master_message_data[$message_id]);
                }
                $outer_design_files[]=isset($outer_design_data[$message_id])?$outer_design_data[$message_id]:'';
                $inner_design_files[]=isset($inner_design_data[$message_id])?$inner_design_data[$message_id]:'';
            }
            $file_name = $master_file->post_uploaded_recipient_file;
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
            $writer->save(public_path('storage/'.$file_name));
            $file_path=convertImageToPdfAndMerge($outer_design_files,$inner_design_files,$file_name);
            $master_file->inner_design_file=trim($file_path['inner_file_name']);
            $master_file->outer_design_file=trim($file_path['outer_file_name']);
            $master_file->save();
        } catch (Exception $e) {
        }
    }
}
}