<?php

namespace App\Http\Controllers;

use App\Models\Library;
use App\Models\NotificationsModel;
use Illuminate\Http\Request;
use Notification;
use App\Models\User;
use App\Notifications\EmailNotification;
use Illuminate\Notifications\Notification as NotificationsNotification;
use Illuminate\Support\Facades\Notification as FacadesNotification;

class EmailController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index()
    {
        return view('welcome');
    }

    public function sendNotificationLibrary(Request $request)
    {
        if (empty($request)) {
            return;
            \log::error('format date fail');
        }

        if (isset($request->last_month)) {
            $month = $request->last_month;
            $library = Library::whereRaw("
            (EXTRACT(MONTH FROM EXPIRED)) = (EXTRACT(MONTH FROM CURRENT_DATE) -" . $month . ") AND
			(EXTRACT(YEAR FROM EXPIRED)) = (EXTRACT(YEAR FROM CURRENT_DATE)) AND
			 DELETED_AT is null
            ")
                ->with('creator')
                ->get();
            //php format month
            $yearMonth = date('Y-m');
        }

        if (!empty($library)) {
            foreach ($library as $row) {
                $creator = $row->creator;
                $expired = \Carbon\Carbon::parse($row->expired)->format('Y-m-d');
                $data = [
                    'user_id' => $creator->id,
                    'name' => $creator->name,
                    'email' => $creator->email,
                    'headerNotif' => 'Expired Notifications',
                    'bodyNotif' => 'Your library expired date is expired at ' . customHanyaTanggal($expired, 'd F Y'),
                    'contentNotif' => 'Please check your document <span style="color:blue;">' . $row->title . '</span>',
                    'url' => url('/read-notif?notif_id=' . $row->id . '&notif_type=library&usr=' . $creator->id)
                ];
                try {
                    //check if user has notification
                    $cek = NotificationsModel::where('notifiable_id', $row->id)
                        ->where('user_id', $creator->id)
                        ->where('notifiable_type', 'like', 'library%')
                        ->where('read_at', null)
                        ->whereRaw("to_char(created_at, 'YYYY-MM') = '" . $yearMonth . "'")->first();
                    if (empty($cek)) {
                        $notif = new NotificationsModel();
                        $notif->id = generate_id();
                        $notif->type = 'mail';
                        $notif->notifiable_type = 'library';
                        $notif->notifiable_id = $row->id;
                        $notif->user_id = $creator->id;
                        $notif->data = json_encode($data);
                        $notif->created_at = now();
                        $notif->save();

                        FacadesNotification::route('mail', $creator->email)
                            ->notify(new EmailNotification($data));

                        return response()->json(['status' => 'success', 'message' => 'Success send email notification to ' . $creator->name]);
                    }
                } catch (\Exception $e) {
                    \Log::error($e->getMessage());
                }
            } //endforeach

        } //endif
        return response()->json(['status' => 'error', 'message' => 'No Data Notification']);
    } //end function

    public function changeReadNotification(Request $request)
    {
        if (empty($request)) {
            return;
            \log::error('format request change status read-at fail');
        }
        if (isset($request->notif_id) && isset($request->notif_type) && isset($request->usr)) {
            $notif_id = $request->notif_id;
            $notif_type = $request->notif_type;
            $user_id = $request->usr;
            $notif = NotificationsModel::where('notifiable_id', $notif_id)
                ->where('user_id', $user_id)
                ->where('notifiable_type', 'like', $notif_type . '%')
                ->update(['read_at' => now()]);
            if ($notif) {
                $row = Library::find($notif_id);
                return redirect('library/filter?category=' . $row->category_libraries);
            }
        }
        return response()->json(['status' => 'error', 'message' => 'No Data Notification']);
    }
}
