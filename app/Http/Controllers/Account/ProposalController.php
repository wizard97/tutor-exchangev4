<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Proposals\SchoolProposal;
use App\Proposals\LevelsProposal;
use App\Proposals\SchoolSubjectProposal;


class ProposalController extends Controller
{
    public function __construct(SchoolProposal $sp, LevelsProposal $lp, SchoolSubjectProposal $ssp)
    {
      $this->sp = $sp;
      $this->lp = $lp;
      $this->ssp = $ssp;
    }

    public function index()
    {
/*

      $lpf = app()->make('App\Proposals\LevelsProposalFactory', ['uid' => 1, 'cid' => 1, 'pending' => false]);

      $lpf->addNextLevel(null, "I am stupid");
      $lpf->addNextLevel(null, "Slightly smarter");
      $lpf->addNextLevel(null, "Very Smart");


      $lp = $lpf->createLevelsProposal();
      $lp->save();
      $lp->accept();

      $this->lp->load_by_id(2);
      $this->lp->accept();

      */
      /*
      $this->sp->create_new(1, "Example pending school", 12345);
      $this->sp->save();
      */
      //$this->sp->load_by_id(1);
      //$this->sp->accept();

      $this->ssp->create_new($uid = 1, $subject_name=null,
          $pending=false, $school_id=null, $sub_id=10, $to_delete = true);
      $this->ssp->save();
      echo "Calling accept";
      $this->ssp->accept();

      return "Added proposal";
    }
}
