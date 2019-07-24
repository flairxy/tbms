<?php

namespace App\Http\Controllers\API\User;

use App\Account;
use App\Deposit;
use App\Setting;
use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\CoinPayments;
use App\User;
use App\Gateway;
use Illuminate\Support\Str;


class UserDepositController extends Controller
{
    public function create(Request $request)
    {
        $this->validate($request, [
            'gateway' => 'required',
            'amount' => 'required'
        ]);

        $gateway = Gateway::find($request->gateway);
        $user = User::findOrFail($request->user);
        $percentage = $gateway->charge;
        $code = Str::random(10);
        if ($gateway->name === 'BITCOIN') {
            $currency = 'BTC';
        } elseif ($gateway->name === 'ETHEREUM') {
            $currency = 'ETH';
        } elseif ($gateway->name === 'BLUEKEY') {
            $currency = 'BKY';

        }

        $charge = (($percentage / 100) * $request->amount);
        $new_amount = $request->amount + $charge - $charge;
        $publicKey = 'de8b403d2727ece788ad4e7a85a91c6a5bb28085bfa444d9e9c572800b59e9aa';
        $privateKey = '879827619B0A31d71ae404B89690e6be0826f64b1d2BD84D94871ED1235D35a4';
        $cps = new CoinPayments();
        $cps->Setup($privateKey, $publicKey);
        $req = array(
            'amount' => $request->amount,
            'currency1' => 'USD',
            'currency2' => $currency,
            'buyer_email' => $user->email,
            'buyer_name' => $user->name,
            'item_name' => 'Instant Deposit',
            'custom' => $user->id,
            'item_number' => $code . $user->id,
            'address' => '',
            'ipn_url' => route('userDepositCrypto'),
        );

        $result = $cps->CreateTransaction($req);

        if ($result['error'] == 'ok') {

            Deposit::create([

                'amount' => $request->amount,
                'currency1' => 'USD',
                'currency2' => $currency,
                'details' => 'Instant Deposit',
                'transaction_id' => $code . $user->id,
                'user_id' => $user->id,
                'gateway_id' => $gateway->id,
                'charge' => $charge,
                'amount2' => $result['result']['amount'],
                'net_amount' => $new_amount,
                'status' => 0,
                'created_at' => Carbon::now(),
                'payment' => 0,

            ]);

            return Response([
                'data' => $result['result']['status_url']
            ]);

        } else {

            print 'Error: ' . $result['error'] . "\n";
        }
    }

    public function cryptoStatus(Request $request)
    {
        $gateway = Gateway::find($request->gateway);

        $cp_merchant_id = '822027e7744027eb9a1d5f4966091bce';
        $cp_ipn_secret = 'whatyouseeiswhatyouget';
        $cp_debug_email = config('mail.from.address', 'okonkwoflair@gmail.com');
        function errorAndDie($error_msg)
        {
            global $cp_debug_email;
            if (!empty($cp_debug_email)) {
                $report = 'Error: ' . $error_msg . "\n\n";
                $report .= "POST Data\n\n";
                foreach ($_POST as $k => $v) {
                    $report .= "|$k| = |$v|\n";
                }
                mail($cp_debug_email, 'CoinPayments IPN Error', $report);
            }
            die('IPN Error: ' . $error_msg);
        }

        if (!isset($_POST['ipn_mode']) || $_POST['ipn_mode'] != 'hmac') {
            errorAndDie('IPN Mode is not HMAC');
        }
        if (!isset($_SERVER['HTTP_HMAC']) || empty($_SERVER['HTTP_HMAC'])) {
            errorAndDie('No HMAC signature sent.');
        }
        $request = file_get_contents('php://input');
        if ($request === FALSE || empty($request)) {
            errorAndDie('Error reading POST data');
        }
        if (!isset($_POST['merchant']) || $_POST['merchant'] != trim($cp_merchant_id)) {
            errorAndDie('No or incorrect Merchant ID passed');
        }
        $hmac = hash_hmac("sha512", $request, trim($cp_ipn_secret));
        if (!hash_equals($hmac, $_SERVER['HTTP_HMAC'])) {
            errorAndDie('HMAC signature does not match');
        }
        $txn_id = $_POST['txn_id'];
        $item_name = $_POST['item_name'];
        $item_number = $_POST['item_number'];
        $amount1 = (float)$_POST['amount1'];
        $amount2 = (float)$_POST['amount2'];
        $currency1 = $_POST['currency1'];
        $currency2 = $_POST['currency2'];
        $status = (int)$_POST['status'];
        $status_text = $_POST['status_text'];
        $deposit = Deposit::whereTransactionId($item_number)->first();
        $user = $deposit->user_id;
        $gateway = $deposit->gateway;
        $order_currency = $deposit->currency1;
        $order_total = $deposit->amount;
        if ($currency1 != $order_currency) {
            errorAndDie('Original currency mismatch!');
        }
        if ($amount1 < $order_total) {
            errorAndDie('Amount is less than order total!');
        }
        if ($status >= 100 || $status == 2) {

            if ($deposit->payment == 0) {

                $deposit->status = $status;
                $deposit->payment = 1;
                $deposit->save();

                $deposit->update([
                    'transaction_id' => $item_number,
                    'user_id' => $user->id,
                    'gateway_name' => $gateway->name,
                    'amount' => $amount1,
                    'charge' => $deposit->charge,
                    'net_amount' => $deposit->charge,
                    'status' => 1,
                    'details' => 'Crypto Instant Deposit',
                ]);
                $account = Account::whereUserId($user)->first();
                if ($gateway->name === 'BITCOIN') {
                    $account->btc += $amount1;
                }
                $account->eth += $amount1;
                $account->save();
            }
        } else if ($status < 0) {
            $deposit->status = $status;
            $deposit->save();
        } else {
            $deposit->status = $status;
            $deposit->save();
        }
        die('IPN OK');

    }

    public function delete($id)
    {
        $this->authorize('isSuperAdmin');

        $deposit = Deposit::findOrFail($id);
        $deposit->delete();
        return response('Deposit deleted successfully');

    }

    public function index($id)
    {
        $deposits = Deposit::whereUserId($id)->orderBy('id', 'desc')->get();
        return response($deposits);
    }

    public function exchange(Request $request)
    {
        $this->validate($request, [
            'old' => 'required',
            'new' => 'required',
            'amount' => 'required'
        ]);
        $user = User::findOrFail($request->user);
        $account = Account::whereUserId($user->id)->first();
        $rate = Setting::whereName('BKY_EXCHANGE_RATE')->first();
        switch ($request->old) {
            case 'BTC':
                $total = $request->amount / $rate->value;
                if ($account->btc >= $request->amount) {
                    $account->bky += $request->amount;
                    $account->bky2 += $total;
                    $account->btc -= $request->amount;
                    $account->save();
                    return response([
                        'message' => 'Exchange Successful',
                        'status' => 'success',
                    ]);
                }
                return response([
                    'message' => 'Insufficient Funds',
                    'status' => 'error',
                ]);
                break;
            case 'ETH':
                $total = $request->amount / $rate->value;
                if ($account->eth >= $request->amount) {
                    $account->bky += $request->amount;
                    $account->bky2 += $total;
                    $account->eth -= $request->amount;
                    $account->save();
                    return response([
                        'message' => 'Exchange Successful',
                        'status' => 'success',
                    ]);
                }
                return response([
                    'message' => 'Insufficient Funds',
                    'status' => 'error',
                ]);
                break;
            default:
                break;
        }
        return response([
            'message' => 'Failed to process exchange.',
            'status' => 'error',
        ]);
    }
}
