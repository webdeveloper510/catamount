<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\User;
use App\Models\Proposal;
use App\Models\ProposalInfo;
use Crypt;

class EmailController extends Controller
{
    public function index(){
    
        
        $leads = Lead::where('status', '>=', 1)->get();
        $proposalUsers = ProposalInfo::select('created_by')->distinct()->get()->pluck('created_by')->toArray();
        $users = User::whereIn('id', $proposalUsers)->get();
        return view('email_integration.index', compact('leads', 'users'));

    }
    public function details($id){
        $id = decrypt(urldecode($id));
        $lead_id = ProposalInfo::select('id', 'lead_id')
        ->where('created_by', $id)
        ->distinct()
        ->groupBy('lead_id')
        ->get()
        ->toArray();
    

        // $lead_id = ProposalInfo::select('*')->where('created_by',$id)->distinct()->get()->toArray();
        // $convers = ProposalInfo::select('*')->where('created_by',$id)->distinct('lead_id')->get();
        // echo "<pre>";print_r($convers);die;
        // $leads = Lead::whereIn('id', $lead_id)->get();
        return view('email_integration.communication',compact('lead_id'));
    }
    public function conversations($id){
        $id = decrypt(urldecode($id));
        $pro= ProposalInfo::find($id);
        $emailCommunications= ProposalInfo::where('created_by',$pro->created_by)->where('lead_id',$pro->lead_id)->orderBy('id', 'desc')->get();
        return view('email_integration.conversation',compact('emailCommunications','id'));
    }
}