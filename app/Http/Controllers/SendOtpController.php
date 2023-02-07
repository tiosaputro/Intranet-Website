<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\GeneralParams;
use App\Models\LogSendOtp;
use App\Models\OtpUser;
use App\Models\UserProfile;
use App\Notifications\EmailNotification;
use App\Notifications\EmailOtpNotification;
use App\Services\WhatsappApi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class SendOtpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $newsServices;
    protected $dirView;
    public function __construct(WhatsappApi $services){
        $this->whatsapp = $services;
    }

    public function sendOtpWa(Request $request){
        $params = GeneralParams::getArray('setting-otp');
        if(!$params['otp_active']){
            return response()->json(['error'=>'OTP is not active'], 401);
        }
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }
        $phone = '+62'.$request->phone;
        $otp = random_int(100000,999999);
        $menit = $params['expired_time'];
        $post = [
            'phone'   => $phone,
            'message' => '*EMP SIAP* Kode OTP Anda adalah *'.$otp.'*. Berlaku selama '.$menit.' Menit. (Percobaan)',
            'spintax' => true
          ];
        $userId = isset($request->userId) ? $request->userId : $phone;
        $appName = isset($request->app) ? $request->app : 'intranet';
        //check platform
        $agent = new Agent();
        //check mobile
        if($agent->isMobile()){
            $mobile = 1;
        }else{
            $mobile = 0;
        }

        $expiredTime = Carbon::now()->addMinutes($params['expired_time']);
        $expiredTime = $expiredTime->format('Y-m-d H:i:s');
        //expired date days
        $expiredDate = Carbon::now()->addDays($params['expired_date']);
        $expiredDate = $expiredDate->format('Y-m-d H:i:s');
        try{
            //service API Whatsapp
            if($params['otp_active']){
                $response = $this->whatsapp->sendMessage($post);
            }else{
                return response()->json(['status' => 'error', 'message' => 'Fitur OTP Whatsapp sedang dinonaktifkan. Gunakan Fitur OTP lainnya.'], 500);
            }

            if(isset($response->status) && $response->status == true){
            // if($response){
                //save to otp user table
                $checkOtp = OtpUser::where('phone', $phone)->first();
                if(empty($checkOtp)){
                    $insertOtpuser = new OtpUser();
                    $insertOtpuser->created_at = date('Y-m-d H:i:s');
                }else{
                    //add updated_at array
                    $insertOtpuser = $checkOtp;
                    $insertOtpuser->updated_at = date('Y-m-d H:i:s');
                    $insertOtpuser->updated_by = $userId;
                    //update otp user
                }

                $insertOtpuser->user_id = $userId;
                $insertOtpuser->application_name = $appName;
                $insertOtpuser->path = $request->fullUrl();
                $insertOtpuser->otp = $otp;
                $insertOtpuser->email = null;
                $insertOtpuser->phone = $phone;
                $insertOtpuser->status = "send";
                $insertOtpuser->is_mobile = $mobile;
                $insertOtpuser->device_name = $agent->device();
                $insertOtpuser->device_platform = $agent->platform();
                $insertOtpuser->ip_address = $request->getClientIp(true);
                $insertOtpuser->expired_otp = $expiredTime;
                $insertOtpuser->expired_date = $expiredDate;
                $insertOtpuser->created_by = $userId;
                //save to otp user table
                $insertOtpuser->save();

                //save to log send otp table
                $logOtp = new LogSendOtp();
                $logOtp->otp_user_id = $insertOtpuser->id;
                $logOtp->via = 'whatsapp';
                $logOtp->status = 'success';
                $logOtp->code = $otp;
                $logOtp->is_mobile = $mobile;
                $logOtp->device_name = $agent->device();
                $logOtp->device_platform = $agent->platform();
                $logOtp->ip_address = $request->getClientIp(true);
                $logOtp->user_agent = $request->header('User-Agent');
                $logOtp->created_by = $phone;
                $logOtp->save();

                return response()->json(['status' => 'success', 'message' => 'Kode OTP berhasil dikirimkan', 'data' => $logOtp], 200);
            }else{
                //save to log send otp table
                $logOtp = new LogSendOtp();
                $logOtp->otp_user_id = $userId;
                $logOtp->via = 'whatsapp';
                $logOtp->status = 'error';
                $logOtp->code = $otp;
                $logOtp->is_mobile = $mobile;
                $logOtp->device_name = $agent->device();
                $logOtp->device_platform = $agent->platform();
                $logOtp->ip_address = $request->getClientIp(true);
                $logOtp->user_agent = $request->header('User-Agent');
                $logOtp->created_by = $phone;
                $logOtp->updated_by = $phone;
                $logOtp->save();

                return response()->json(['status' => 'error', 'message' => 'Kode OTP gagal dikirimkan', 'data' => $logOtp], 200);
            }
        }catch(\ErrorException $e){
            return response()->json(['error'=>$e->getMessage()], 500);
        }
    }

    public function sendOtpEmail(Request $request){
        $params = GeneralParams::getArray('setting-otp');
        if(!$params['otp_active']){
            return response()->json(['error'=>'OTP is not active'], 401);
        }
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }
        $email = $request->email;
        $otp = random_int(100000,999999);
        $menit = $params['expired_time'];

        $userId = isset($request->userId) ? $request->userId : $email;
        $appName = isset($request->app) ? $request->app : 'intranet';
        //check platform
        $agent = new Agent();
        //check mobile
        if($agent->isMobile()){
            $mobile = 1;
        }else{
            $mobile = 0;
        }

        $expiredTime = Carbon::now()->addMinutes($params['expired_time']);
        $expiredTime = $expiredTime->format('Y-m-d H:i:s');
        //expired date days
        $expiredDate = Carbon::now()->addDays($params['expired_date']);
        $expiredDate = $expiredDate->format('Y-m-d H:i:s');
        try{
            $dataMail = [
                'user_id' => $userId,
                'name' => 'EMP SIAP - Email OTP',
                'email' => $email,
                'headerNotif' => 'One Time Password',
                'bodyNotif' => 'Masa berlaku kode OTP '.$menit.' menit atau hingga ' . $expiredTime . ' WIB',
                'contentNotif' => 'Silahkan masukan kode ini ke aplikasi <br/><br/><div style="text-align:center;"><span style="color:blue; font-size:18pt;">' . $otp . '</span></div>'
            ];
            //Notifikasi email
            try{
                $response = true;
                Notification::route('mail', $email)
                    ->notify(new EmailOtpNotification($dataMail));
            }catch(\ErrorException $e){
                $response = false;
                //save log
                Log::error('Error send email otp: ' . $e->getMessage());
            }

            if($response){
                //save to otp user table
                $checkOtp = OtpUser::where('user_id', $userId)->first();
                if(empty($checkOtp)){
                    $insertOtpuser = new OtpUser();
                    $insertOtpuser->created_at = date('Y-m-d H:i:s');
                }else{
                    //add updated_at array
                    $insertOtpuser = $checkOtp;
                    $insertOtpuser->updated_at = date('Y-m-d H:i:s');
                    $insertOtpuser->updated_by = $userId;
                    //update otp user
                }

                $insertOtpuser->user_id = $userId;
                $insertOtpuser->application_name = $appName;
                $insertOtpuser->path = $request->fullUrl();
                $insertOtpuser->otp = $otp;
                $insertOtpuser->email = $email;
                $insertOtpuser->status = "send";
                $insertOtpuser->is_mobile = $mobile;
                $insertOtpuser->device_name = $agent->device();
                $insertOtpuser->device_platform = $agent->platform();
                $insertOtpuser->ip_address = $request->getClientIp(true);
                $insertOtpuser->expired_otp = $expiredTime;
                $insertOtpuser->expired_date = $expiredDate;
                $insertOtpuser->created_by = $userId;
                //save to otp user table
                $insertOtpuser->save();

                //save to log send otp table
                $logOtp = new LogSendOtp();
                $logOtp->otp_user_id = $insertOtpuser->id;
                $logOtp->via = 'email';
                $logOtp->status = 'success';
                $logOtp->code = $otp;
                $logOtp->is_mobile = $mobile;
                $logOtp->device_name = $agent->device();
                $logOtp->device_platform = $agent->platform();
                $logOtp->ip_address = $request->getClientIp(true);
                $logOtp->user_agent = $request->header('User-Agent');
                $logOtp->created_by = $email;
                $logOtp->save();

                return response()->json(['status' => 'success', 'message' => 'Kode OTP berhasil dikirimkan', 'data' => $logOtp], 200);
            }else{
                //save to log send otp table
                $logOtp = new LogSendOtp();
                $logOtp->otp_user_id = $userId;
                $logOtp->via = 'email';
                $logOtp->status = 'error';
                $logOtp->code = $otp;
                $logOtp->is_mobile = $mobile;
                $logOtp->device_name = $agent->device();
                $logOtp->device_platform = $agent->platform();
                $logOtp->ip_address = $request->getClientIp(true);
                $logOtp->user_agent = $request->header('User-Agent');
                $logOtp->created_by = $email;
                $logOtp->updated_by = $email;
                $logOtp->save();

                return response()->json(['status' => 'error', 'message' => 'Kode OTP gagal dikirimkan', 'data' => $logOtp], 200);
            }
        }catch(\ErrorException $e){
            return response()->json(['error'=>$e->getMessage()], 500);
        }
    }

    public function verifyOtp(Request $request){
        //verifikasi via email
        if(!empty($request->email)){
            //validasi phone except
            return $this->verifyOtpEmail($request);
        }else{
            //validate phone
            $validator = Validator::make($request->all(), [
                'phone' => 'required',
                'otp' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['error'=>$validator->errors()], 401);
            }
        }
        //verifikasi via phone
        $app = isset($request->app) ? $request->app : 'intranet'; //set application name
        try{
            $phone = '+62'.$request->phone;
            $otp = $request->otp;
            $expiredTime = Carbon::now();
            $expiredTime = $expiredTime->format('Y-m-d H:i:s');
            $checkOtp = OtpUser::where('phone', $phone)->where('otp', $otp)->where('application_name', $app)->first();
            if(empty($checkOtp)){
                return response()->json(['status' => 'error','message'=>'Kode OTP tidak valid. Periksa kembali pesan whatsapp anda.'], 401);
            }else{
                //check expired time
                if(strtotime($checkOtp->expired_otp) < strtotime($expiredTime)){
                    return response()->json(['status' => 'error','message'=>'Kode OTP sudah tidak berlaku. Silahkan kirim ulang kode OTP.'], 401);
                }
            }
            $checkOtp->status = 'valid';
            $checkOtp->save();
            //update phone on user_profile
            $userProfile = UserProfile::where('user_id', $checkOtp->user_id)->first();
            if(!empty($userProfile)){
                $userProfile->phone = $phone;
                $userProfile->save();
            }
            return response()->json(['status' => 'success', 'message' => 'Kode OTP berhasil diverifikasi', 'data' => $checkOtp], 200);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()], 500);
        }
    }

    private function verifyOtpEmail($request){
        //validate email
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'otp' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }
        $app = isset($request->app) ? $request->app : 'intranet'; //set application name
        try{
            $email = $request->email;
            $otp = $request->otp;
            $expiredTime = Carbon::now();
            $expiredTime = $expiredTime->format('Y-m-d H:i:s');
            $checkOtp = OtpUser::where('email', $email)->where('otp', $otp)->where('application_name', $app)->first();
            if(empty($checkOtp)){
                return response()->json(['status' => 'error','message'=>'Kode OTP tidak valid. Periksa kembali email anda.'], 401);
            }else{
                //check expired time
                if(strtotime($checkOtp->expired_otp) < strtotime($expiredTime)){
                    return response()->json(['status' => 'error','message'=>'Kode OTP sudah tidak berlaku. Silahkan kirim ulang kode OTP.'], 401);
                }
            }
            $checkOtp->status = 'valid';
            $checkOtp->save();
            //update user_email on user_profile
            $userProfile = UserProfile::where('user_id', $checkOtp->user_id)->first();
            if(!empty($userProfile)){
                $userProfile->user_email = $email;
                $userProfile->save();
            }
            return response()->json(['status' => 'success', 'message' => 'Kode OTP berhasil diverifikasi', 'data' => $checkOtp], 200);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()], 500);
        }
    }
}
