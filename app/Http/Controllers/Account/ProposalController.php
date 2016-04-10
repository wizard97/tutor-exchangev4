<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\Proposals\School\SchoolProposalRepository;
use App\Repositories\Proposals\Proposal\ProposalRepository;
use App\Http\Requests\ProposeSchoolRequest;

class ProposalController extends Controller
{
    public function __construct()
    {

    }

    public function index(ProposalRepository $pr)
    {
        $proposals = $pr->getUsersProposals(\Auth::id());
        return view('/account/proposals/index', compact('proposals'));
    }

    public function getsubmitclass()
    {
        return view('/account/proposals/submitclass');
    }
    public function getSubmitSchool()
    {
        return view('/account/proposals/submitschool');
    }

    public function postSubmitSchool(ProposeSchoolRequest $request, SchoolProposalRepository $spr)
    {
        try
        {
            $spr->create($request->all(), \Auth::id());
        }
        catch(\Exception $e)
        {
            $error = $e->getMessage();
            $request->session()->put('feedback_negative', "An unexpected error occured.");
            return back();
        }

        $request->session()->put('feedback_positive', 'Your proposal was recorded.');
        return back();
    }

    public function getsubmitsubject()
    {
        return view('/account/proposals/submitsubject');
    }
}
