<?php

use Carbon\Carbon;
use App\Models\User;
use App\Models\Enquiry;
use Image as thumbimage;
use App\Models\DisplayMsg;
use App\Models\UserDevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Tymon\JWTAuth\Exceptions\JWTException;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;


if (!function_exists('errorMessage')) {
    function errorMessage($msg = '', $data = array(), $expireSessionCode = "")
    {
        $return_array = array();
        $return_array['success'] = '0';
        if ($expireSessionCode != "") {
            $return_array['success'] = $expireSessionCode;
        }
        $return_array['message'] = $msg;
        if (isset($data) && count($data) > 0)
            $return_array['data'] = $data;
        if (isset($other_data) && !empty($other_data)) {
            foreach ($other_data as $key => $val)
                $return_array[$key] = $val;
        }
        echo json_encode($return_array);
        exit();
    }
}

if (!function_exists('successMessage')) {
    function successMessage($msg = '', $data = array())
    {
        $return_array = array();
        $return_array['success'] = '1';
        $return_array['message'] = $msg;
        if (isset($data) && count($data) > 0)
            $return_array['data'] = $data;
        if (isset($other_data) && !empty($other_data)) {
            foreach ($other_data as $key => $val)
                $return_array[$key] = $val;
        }
        echo json_encode($return_array);
        exit();
    }
}

if (!function_exists('generateRandomOTP')) {
    function generateRandomOTP()
    {
        // return (rand(1000,9999));
        return (1234);
    }
}

if (!function_exists('readHeaderToken')) {
    function readHeaderToken()
    {
        $msg_data = array();
        $tokenData = Session::get('tokenData');
        $userDeviceData = Session::get('userDeviceData');
        $token = JWTAuth::setToken($tokenData)->getPayload();
        $userChk = UserDevice::where([['user_id', $token['sub']], ['device_id', $userDeviceData]])->get();
        if (count($userChk) == 0 || $userChk[0]->remember_token == '') {
            errorMessage(__('auth.please_login_and_try_again'), $msg_data, 4);
        }
        return $token;
    }
}

if (!function_exists('checkPermission')) {
    function checkPermission($name)
    {
        $role_id = session('data')['role_id'];

        // Allow access if the role ID is 1 or 2
        if ($role_id == 1 || $role_id == 2) {
            return true;
        }

        $permissions = Session::get('permissions');
        $permission_array = [];

        foreach ($permissions as $permission) {
            $permission_array[] = $permission->codename;
        }

        return in_array($name, $permission_array);
    }
}

if (!function_exists('generateSeoURL')) {
    function generateSeoURL($string, $wordLimit = 0)
    {
        $separator = '-';
        if ($wordLimit != 0) {
            $wordArr = explode(' ', $string);
            $string = implode(' ', array_slice($wordArr, 0, $wordLimit));
        }
        $quoteSeparator = preg_quote($separator, '#');
        $trans = array(
            '&.+?;'                    => '',
            '[^\w\d _-]'            => '',
            '\s+'                    => $separator,
            '(' . $quoteSeparator . ')+' => $separator
        );
        $string = strip_tags($string);
        foreach ($trans as $key => $val) {
            $UTF8_ENABLED = config('global.UTF8_ENABLED');
            $string = preg_replace('#' . $key . '#i' . ($UTF8_ENABLED ? 'u' : ''), $val, $string);
        }
        $string = strtolower($string);
        return trim(trim($string, $separator));
    }
}

if (!function_exists('approvalStatusArray')) {
    function approvalStatusArray($displayValue = "", $allKeys = false)
    {
        $returnArray = array(
            'pending' => 'Pending',
            'accepted' => 'Accepted',
            'rejected' => 'Rejected'
        );
        if (!empty($displayValue)) {
            $returnArray = $returnArray[$displayValue];
        }
        if (empty($displayValue) && $allKeys) {
            $returnArray = array_keys($returnArray);
        }
        return $returnArray;
    }
}

/**
 *   created by : Karan Suryavanshi
 *   Created On : 09-aug-2022
 *   Uses : To display globally status 0|1 as Active|In-Active in view pages
 *   @param $key
 *   @return Response
 */
if (!function_exists('displayStatus')) {
    function displayStatus($displayValue = "")
    {
        $returnArray = array(
            '1' => 'Active',
            '0' => 'In-Active'
        );
        if (isset($displayValue)) {
            $returnArray = $returnArray[$displayValue];
        }

        return $returnArray;
    }
}

/**
 *   created by : Karan Suryavanshi
 *   Created On : 16-aug-2022
 *   Uses : To display globally dropdown status 0|1 as Yes|no in view pages and
 *   @param $key
 *   @return Response
 */
if (!function_exists('dropdownStatus')) {
    function dropdownStatus($displayValue = "", $allKeys = false)
    {
        $returnArray = array(
            '1' => 'Yes',
            '0' => 'No'
        );
        if ($displayValue != '' || $displayValue != NULL) {
            $returnArray = $returnArray[$displayValue];
        }
        if (empty($displayValue) && $allKeys) {
            $returnArray = array_keys($returnArray);
        }
        return $returnArray;
    }
}

/**
 *   created by : Karan Suryavanshi
 *   Created On : 16-aug-2022
 *   Uses : To display globally Featured 0|1 as  Featured|Un-Featured in view pages
 *   @param $key
 *   @return Response
 */
if (!function_exists('displayFeatured')) {
    function displayFeatured($displayValue = "")
    {
        $returnArray = array(
            '1' => 'Featured',
            '0' => 'Un-Featured'
        );
        if (isset($displayValue)) {
            $returnArray = $returnArray[$displayValue];
        }

        return $returnArray;
    }
}

/**
 *   created by : Karan Suryavanshi
 *   Created On : 16-aug-2022
 *   Uses :  To fetch value in attribute value for type
 */
if (!function_exists('attributeValueType')) {
    function attributeValueType($displayValue = "", $allKeys = false)
    {
        $returnArray = array(
            'brand' => 'Brand',
            'collection' => 'Collection',
            'category' => 'Category',
            'sub_category' => 'Sub Category'
        );
        if (!empty($displayValue)) {
            $returnArray = $returnArray[$displayValue];
        }
        if (empty($displayValue) && $allKeys) {
            $returnArray = array_keys($returnArray);
        }
        return $returnArray;
    }
}

/**
 *   created by : Karan Suryavanshi
 *   Created On : 09-aug-2022
 *   Uses :  To fetch value in order delivery status type
 */
if (!function_exists('deliveryStatus')) {
    function deliveryStatus($displayValue = "", $allKeys = false)
    {
        $returnArray = array(
            'pending' => 'Pending',
            'processing' => 'Processing',
            'out_for_delivery' => 'Out For Delivery',
            'delivered' => 'Delivered',
            'cancelled' => 'Cancelled',
            'returned' => 'Returned'
        );
        if (!empty($displayValue)) {
            $returnArray = $returnArray[$displayValue];
        }
        if (empty($displayValue) && $allKeys) {
            $returnArray = array_keys($returnArray);
        }
        return $returnArray;
    }
}

/**
 *   created by : Karan Suryavanshi
 *   Created On : 16-aug-2022
 *   Uses :  To fetch value in order payment status type
 */
if (!function_exists('paymentStatus')) {
    function paymentStatus($displayValue = "", $allKeys = false)
    {
        $returnArray = array(
            'pending' => 'Pending',
            'paid' => 'Paid',
            'failed' => 'Failed',
            'refund_initiated' => 'Refund Initiated',
            'refund_completed' => 'Refund Completed'
        );
        if (!empty($displayValue)) {
            $returnArray = $returnArray[$displayValue];
        }
        if (empty($displayValue) && $allKeys) {
            $returnArray = array_keys($returnArray);
        }
        return $returnArray;
    }
}


/**
 *   created by : Karan Suryavanshi
 *   Created On : 16-aug-2022
 *   Uses :  To fetch value in user subscription payment type
 */
if (!function_exists('paymentType')) {
    function paymentType($displayValue = "", $allKeys = false)
    {
        $returnArray = array(
            'cash' => 'Cash',
            'online_payment' => 'Online Payment'
        );
        if (!empty($displayValue)) {
            $returnArray = $returnArray[$displayValue];
        }
        if (empty($displayValue) && $allKeys) {
            $returnArray = array_keys($returnArray);
        }
        return $returnArray;
    }
}

/**
 *   Created by : Karan Suryavanshi
 *   Created On : 16-aug-2022
 *   Uses: This function will be used to full search data in api.
 */
if (!function_exists('fullSearchQuery')) {
    function fullSearchQuery($query, $word, $params)
    {
        $orwords = explode('|', $params);
        $query = $query->where(function ($query) use ($word, $orwords) {
            foreach ($orwords as $key) {
                $query->orWhere($key, 'like', '%' . $word . '%');
            }
        });
        return $query;
    }
}

/**
 *   created by : Karan Suryavanshi
 *   Created On : 16-aug-2022
 *   Uses :  To fetch value in user address
 */
if (!function_exists('addressType')) {
    function addressType($displayValue = "", $allKeys = false)
    {
        $returnArray = array(
            'shipping' => 'Shipping',
            'billing' => 'Billing'
        );
        if (!empty($displayValue)) {
            $returnArray = $returnArray[$displayValue];
        }
        if (empty($displayValue) && $allKeys) {
            $returnArray = array_keys($returnArray);
        }
        return $returnArray;
    }
}

/**
 *   created by : Karan Suryavanshi
 *   Created On : 16-aug-2022
 *   Uses :  To fetch value in gst type dropdown in customer enquiry map to vendor
 */
if (!function_exists('gstType')) {
    function gstType($displayValue = "", $allKeys = false)
    {
        $returnArray = array(
            'not_applicable' => 'Not Applicable',
            'cgst+sgst' => 'CGST+SGST',
            'igst' => 'IGST'
        );
        if (!empty($displayValue)) {
            $returnArray = $returnArray[$displayValue];
        }
        if (empty($displayValue) && $allKeys) {
            $returnArray = array_keys($returnArray);
        }
        return $returnArray;
    }
}

/**
 *   created by : Karan Suryavanshi
 *   Created On : 16-aug-2022
 *   Uses :  To fetch value in order Status in order table
 */
if (!function_exists('orderStatus')) {
    function orderStatus($displayValue = "", $allKeys = false)
    {
        $returnArray = array(
            'initiated' => 'Initiated',
            'processing' => 'Processing',
            'cancelled' => 'Cancelled',
            'completed' => 'Completed',
            'returned' => 'Returned'

        );
        if (!empty($displayValue)) {
            $returnArray = $returnArray[$displayValue];
        }
        if (empty($displayValue) && $allKeys) {
            $returnArray = array_keys($returnArray);
        }
        return $returnArray;
    }
}

/**
 *   created by : Karan Suryavanshi
 *   Created On : 16-aug-2022
 *   Uses :  to get pin code details
 */


if (!function_exists('getPincodeDetails')) {
    function getPincodeDetails($pincode)
    {
        $msg_data = array();

        $data = Http::get('https://api.postalpincode.in/pincode/' . $pincode)->json();
        if (empty($data[0]['PostOffice'])) {
            errorMessage(__('pin_code.not_found'), $msg_data);
        }

        $msg_data['city'] = $data[0]['PostOffice'][0]['District'];
        $msg_data['state'] = $data[0]['PostOffice'][0]['State'];
        $msg_data['pin_code'] = $data[0]['PostOffice'][0]['Pincode'];
        return $msg_data;
    }
}

if (!function_exists('getFormatid')) {
    function getFormatid($id)
    {
        // $formatId = str_pad($id, 4, 0, STR_PAD_LEFT);
        // return $formatId;
        return $id;
    }
}


if (!function_exists('convertNumberToWord')) {
    function convertNumberToWord($num = false)
    {
        $num = str_replace(array(',', ' '), '', trim($num));
        if (!$num) {
            return false;
        }
        $num = (int) $num;
        $words = array();
        $list1 = array(
            '', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven',
            'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
        );
        $list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred');
        $list3 = array(
            '', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
            'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
            'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
        );
        $num_length = strlen($num);
        $levels = (int) (($num_length + 2) / 3);
        $max_length = $levels * 3;
        $num = substr('00' . $num, -$max_length);
        $num_levels = str_split($num, 3);
        for ($i = 0; $i < count($num_levels); $i++) {
            $levels--;
            $hundreds = (int) ($num_levels[$i] / 100);
            $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ' ' : '');
            $tens = (int) ($num_levels[$i] % 100);
            $singles = '';
            if ($tens < 20) {
                $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '');
            } else {
                $tens = (int)($tens / 10);
                $tens = ' ' . $list2[$tens] . ' ';
                $singles = (int) ($num_levels[$i] % 10);
                $singles = ' ' . $list1[$singles] . ' ';
            }
            $words[] = $hundreds . $tens . $singles . (($levels && (int) ($num_levels[$i])) ? ' ' . $list3[$levels] . ' ' : '');
        } //end for loop
        $commas = count($words);
        if ($commas > 1) {
            $commas = $commas - 1;
        }

        return ucwords(implode(' ', $words));
    }
}


/**
 *   created by : Karan Suryavanshi
 *   Created On : 16-aug-2022
 *   Uses : To display globally dropdown status 0|1 as Yes|no in view pages and
 *   @param $key
 *   @return Response
 */
if (!function_exists('dropdownStatus')) {
    function dropdownStatus($displayValue = "", $allKeys = false)
    {
        $returnArray = array(
            '1' => 'Yes',
            '0' => 'No'
        );
        if ($displayValue != '' || $displayValue != NULL) {
            $returnArray = $returnArray[$displayValue];
        }
        if (empty($displayValue) && $allKeys) {
            $returnArray = array_keys($returnArray);
        }
        return $returnArray;
    }
}

if (!function_exists('get_finacial_year_range')) {
    function get_finacial_year_range($date = '')
    {
        if (empty($date)) {
            $date = now();
        }
        $year = date('Y', strtotime($date));
        $month = date('m', strtotime($date));
        if ($month < 4) {
            $year = $year - 1;
        }
        $start_date = date('d/m/Y', strtotime(($year) . '-04-01'));
        $end_date = date('d/m/Y', strtotime(($year + 1) . '-03-31'));
        $response = array('start_date' => $start_date, 'end_date' => $end_date);
        return $response;
    }
}

if (!function_exists('get_max_enq_no')) {
    function get_max_enq_no($region_id, $financial_year)
    {
        $start_date = Carbon::createFromFormat('d/m/Y', trim($financial_year['start_date']))->format('Y-m-d');
        $end_date = Carbon::createFromFormat('d/m/Y', trim($financial_year['end_date']))->format('Y-m-d');
        $maxEnqNo = Enquiry::select(DB::raw('max(enq_no*1.0) as enq_no'))
            ->where('region_id', $region_id)
            ->whereDate('enq_register_date', '>=', $start_date)
            ->whereDate('enq_register_date', '<=', $end_date)
            ->value('enq_no');
        return $maxEnqNo;
    }
}

if (!function_exists('arrayChunk')) {

    function arrayChunk(string $path, callable $generator, int $chunk){
        $file = fopen($path, 'r');

        $data = [];

        for ($kk = 0; ($row = fgetcsv($file, null, ',')) != false; $kk) {
            $data[] = $generator($row);

            if ($kk % $chunk == 0) {
                yield $data;
                $data = [];
            }
        }

        if (!empty($data)) {
            yield $data;
        }

        fclose($file);
    }
}

// Added by Karan Suryavanshi
// get single enquiry for edit and view -- START
if (!function_exists('getEnquiryData')) {
    function getEnquiryData()
    {
        $EnquiryData = DB::table('enquiries')->select(
            'enquiries.*',
            'products.product_name',
            'regions.region_name',
            'categories.category_name',
            'engineer_statuses.engineer_status_name',
            'typist_statuses.typist_status_name',
            'allocation_statuses.allocation_status_name',
            'industries.industry_name',
            'ci.admin_name as case_incharge',
            'ci.nick_name as case_incharge_nick_name',
            'eng.admin_name as engineer',
            'eng.nick_name as engineer_nick_name',
            'old_eng.admin_name as old_engineer',
            'old_eng.nick_name as old_engineer_nick_name',
            'typ.admin_name as typist',
            'typ.nick_name as typist_nick_name',
            'old_typ.admin_name as old_typist',
            'old_typ.nick_name as old_typist_nick_name',
        )
            ->leftjoin('products', 'products.id', '=', 'enquiries.product_id')
            ->leftjoin('regions', 'regions.id', '=', 'enquiries.region_id')
            ->leftjoin('categories', 'categories.id', '=', 'enquiries.category_id')
            ->leftjoin('engineer_statuses', 'engineer_statuses.id', '=', 'enquiries.engineer_status')
            ->leftjoin('typist_statuses', 'typist_statuses.id', '=', 'enquiries.typist_status')
            ->leftjoin('allocation_statuses', 'allocation_statuses.id', '=', 'enquiries.allocation_status')
            ->leftjoin('industries', 'industries.id', '=', 'enquiries.industry_id')
            ->leftjoin('admins as ci', 'ci.id', '=', 'enquiries.case_incharge_id')
            ->leftjoin('admins as eng', 'eng.id', '=', 'enquiries.engineer_id')
            ->leftjoin('admins as old_eng', 'old_eng.id', '=', 'enquiries.old_engineer_id')
            ->leftjoin('admins as typ', 'typ.id', '=', 'enquiries.typist_id')
            ->leftjoin('admins as old_typ', 'old_typ.id', '=', 'enquiries.old_typist_id');
        return $EnquiryData;
    }
    // get single enquiry for edit and view -- END

}
