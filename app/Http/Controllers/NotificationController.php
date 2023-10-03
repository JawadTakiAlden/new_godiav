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
        $notifications = Notification::where('branch_id' ,$branchID )->get();
        return response([
            'data' => $notifications
        ]);
    }
}
