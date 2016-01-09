<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Proposals\SchoolProposal;

use App\Proposals\LevelsProposal;


class ProposalController extends Controller
{
    public function __construct(SchoolProposal $sp, LevelsProposal $lp)
    {
      $this->sp = $sp;
      $this->lp = $lp;
    }

    public function index()
    {
      $this->sp->create_new($uid = 1, $name=null, $zip_id = 12345, $school_id=1, $to_delete = true);
      $this->sp->save();
      $this->sp->load_by_id(1);
      $this->sp->accept();
      try {$this->sp->accept();}
      catch (\Exception $e) {echo $e->getMessage();}
      /*
      $lpf = app()->make('App\Proposals\LevelsProposalFactory', ['uid' => 1, 'cid' => 1, 'pending' => false]);
      $lpf->addNextLevel(1, "Level 1");
      $lpf->addNextLevel(null, "Level 2");
      $lpf->addNextLevel(null, "Level 3");
      $lpf->createLevelsProposal($this->lp);
      $this->lp->save();
      echo "Calling accept";
      $this->lp->accept();
      */

      return "Added proposal";
    }
}
