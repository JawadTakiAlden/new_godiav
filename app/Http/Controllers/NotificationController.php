<?php

namespace App\Http\Controllers;

use App\CustomResponse\ApiResponse;
use App\Models\Branch;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    use ApiResponse;
    public function index($branchID){
        $branch = Branch::where('id' , $branchID)->first();
        if(!$branch){
            return $this->error('Requested Branch Not Found' , 404);
        }
        $notifications = Notification::where('branch_id' ,$branchID )->where('is_read' , true)->get();
        return response([
            'data' => $notifications
        ]);
    }

    public function markAllAsRead($branchID){
        $branch = Branch::where('id' , $branchID)->first();
        if(!$branch){
            return $this->error('Requested Branch Not Found' , 404);
        }
        $notifications = Notification::where('branch_id' ,$branchID )->get();
        if ($notifications){
            foreach ($notifications as $notification){
                $notification->update([
                    'is_read' => true
                ]);
            }
        }
        return response([
            'message' => 'all notification marked as read'
        ]);
    }
}
