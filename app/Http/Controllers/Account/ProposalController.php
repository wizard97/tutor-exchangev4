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
      $this->sp->create_new(1, "New unmerged school", 12345);
      $pid = $this->sp->save();

      $id = \App\Models\Pending\Proposal::findOrFail($pid)->pending_school->id;
      var_dump($id);

      $this->ssp->create_new($uid = 1, $subject_name="first Subject",
          $pending=true, $school_id=$id, $sub_id=null, $to_delete = false);
      $this->ssp->save();
      echo "Calling accept";
      var_dump($this->ssp->dependencies());

      return "Added proposal";
    }
}
