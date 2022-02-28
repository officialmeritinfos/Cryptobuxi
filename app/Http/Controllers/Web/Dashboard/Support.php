<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Custom\GenerateUnique;
use App\Custom\Regular;
use App\Custom\Wallet;
use App\Events\SendNotification;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\GeneralSetting;
use App\Models\Response;
use App\Models\Support as ModelsSupport;
use App\Models\User;
use App\Notifications\AccountNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Support extends BaseController
{
    use GenerateUnique;
    public $wallet;
    public $regular;
    public function __construct() {
        $this->wallet = new Wallet();
        $this->regular = new Regular();
    }
    public function index()
    {
        $web = GeneralSetting::where('id',1)->first();
        $user  = Auth::user();
        $viewData = [
            'siteName'=>$web->siteName,
            'pageName'=>'Support Center',
            'web'=>$web,
            'user'=>$user,
            'tickets'=>ModelsSupport::where('user',$user->id)->where(function($query){
                    return $query->where('status',2)->orWhere('status',4);
                })->paginate(15),
            'departments'=>Department::where('status',1)->get()
        ];
        return view('dashboard.supports',$viewData);
    }
    public function allSupport()
    {
        $web = GeneralSetting::where('id',1)->first();
        $user  = Auth::user();
        $viewData = [
            'siteName'=>$web->siteName,
            'pageName'=>'All Support Tickets',
            'web'=>$web,
            'user'=>$user,
            'tickets_all'=>ModelsSupport::where('user',$user->id)->orderBy('id','DESC') ->paginate(15),
            'departments'=>Department::where('status',1)->get()
        ];
        return view('dashboard.supports',$viewData);
    }
    public function createNew(Request $request)
    {
        $user = Auth::user();
        $web= GeneralSetting::where('id',1)->first();
        $validator = Validator::make($request->all(),
            [
                'title' => ['bail', 'required', 'string'],
                'detail' => ['bail', 'required', 'string'],
                'department' => ['bail', 'required', 'numeric','integer','exists:departments,id'],
            ],
        );
        if ($validator->fails()) {
            return $this->sendError('Error validation', ['error' => $validator->errors()->all()],
            '422', 'Validation Failed');
        }
        $input = $request->input();

        //get an agent for the conversation
        $staff = User::where('is_staff',1)->where('department',$input['department'])->inRandomOrder()->first();
        if (!empty($staff)) {
            $agent = $staff->id;
        }else{
            $agent = null;
        }
        $departments = Department::where('id',$input['department'])->first();
        if (empty($departments)) {
            return $this->sendError('Error validation', ['error' => 'Invalid Department Selected'],
            '422', 'Validation Failed');
        }
        $reference = $this->createUniqueRef('supports','reference');
        $dataSupport=[
            'reference'=>$reference,
            'user'=>$user->id,
            'topic'=>$input['title'],
            'intro'=>$input['detail'],
            'department'=>$input['department'],
            'agent'=>$agent
        ];
        //create the support
        $create= ModelsSupport::create($dataSupport);
        if (!empty($create)) {
            //send mail to the department with lookout for a staff to assign to it
            //also sends mail to the staff allocated if any
            $mailMessage ="A new support request has been opened and associated to the
            <b>".$departments->name."</b> department with Title <b>".$input['title']."</b><br>
            Ticket Reference is <b>".$reference."</b>.";
            $departments->notify(new AccountNotification($departments->name,$mailMessage,url('login'),'New Support Request - '.$reference));
            if ($agent != null) {
                event(new SendNotification($staff,$mailMessage,'New Support Request - '.$reference));
            }
            $success['created']=true;
            return $this->sendResponse($success, 'Ticket Created. A staff will reply shortly');
        }else{
            return $this->sendError('Error validation', ['error' => 'Something went wrong. Please try again or contact
            support about this.'],
            '422', 'Validation Failed');
        }
    }
    public function ticketDetails($ref)
    {
        $web = GeneralSetting::where('id',1)->first();
        $user  = Auth::user();
        $ticket = ModelsSupport::where('user',$user->id)->where('reference',$ref)->first();
        if (empty($ticket)) {
            abort('401');
        }
        $viewData = [
            'siteName'=>$web->siteName,
            'pageName'=>'Ticket Detail',
            'web'=>$web,
            'user'=>$user,
            'ticket'=>$ticket,
            'department'=>Department::where('id',$ticket->department)->first(),
            'responses'=>Response::where('supportId',$ticket->id)->get()
        ];
        return view('dashboard.support_detail',$viewData);
    }
    public function replySupport(Request $request)
    {
        $user = Auth::user();
        $web= GeneralSetting::where('id',1)->first();
        $validator = Validator::make($request->all(),
            [
                'id' => ['bail', 'required', 'numeric'],
                'message' => ['bail', 'required', 'string'],
            ],
        );
        if ($validator->fails()) {
            return $this->sendError('Error validation', ['error' => $validator->errors()->all()],
            '422', 'Validation Failed');
        }
        $input = $request->input();
        $reference = $input['id'];
        //check if the ticket is valid
        $ticket = ModelsSupport::where('user',$user->id)->where('reference',$reference)->first();
        if (empty($ticket)) {
            return $this->sendError('Error validation', ['error' => 'Unauthorized Action. Please contact support'],
            '422', 'Validation Failed');
        }
        $departments = Department::where('id',$ticket->department)->first();
        if (empty($departments)) {
            return $this->sendError('Error validation', ['error' => 'Invalid Department'],
            '422', 'Validation Failed');
        }
        $dataSupportReply=[
            'supportId'=>$ticket->id,
            'message'=>$input['message'],
            'responseType'=>2,
        ];
        $dataSupport =[
            'status' =>2
        ];
        //create the support
        $create= Response::create($dataSupportReply);
        if (!empty($create)) {
            ModelsSupport::where('id',$ticket->id)->update($dataSupport);
            //send mail to the department with lookout for a staff to assign to it
            //also sends mail to the staff allocated if any
            $mailMessage ="There is a customer response to the ticket with Reference  <b>".$reference."</b>.";
            $departments->notify(new AccountNotification($departments->name,$mailMessage,url('login'),'Client Response to Ticket - '.$reference));
            $success['replied']=true;
            return $this->sendResponse($success, 'Response sent. A staff will reply shortly');
        }else{
            return $this->sendError('Error validation', ['error' => 'Something went wrong. Please try again or contact
            support about this.'],
            '422', 'Validation Failed');
        }
    }
    public function closeTicket($ref)
    {
        $user = Auth::user();
        $web= GeneralSetting::where('id',1)->first();
        $ticket = ModelsSupport::where('user',$user->id)->where('reference',$ref)->first();
        if (empty($ticket)) {
            return $this->sendError('Error validation', ['error' => 'Unauthorized Action. Please contact support'],
            '422', 'Validation Failed');
        }
        $dataSupport =[
            'status' =>3
        ];
        $update = ModelsSupport::where('id',$ticket->id)->update($dataSupport);
        if ($update) {
            return redirect('account/support')->with('success','Ticket Closed');
        }else{
            return redirect('account/support')->with('error','Something went wrong');
        }
    }
}
