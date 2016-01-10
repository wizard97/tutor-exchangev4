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


      $lpf = app()->make('App\Proposals\LevelsProposalFactory', ['uid' => 1, 'cid' => 1, 'pending' => true]);

      $lpf->addNextLevel(1, "Test level 1");
      $lpf->addNextLevel(null, "Test Level 2");
      /*
      $lpf->addNextLevel(null, "Level 3");
      */
      $lpf->createLevelsProposal($this->lp);
      $this->lp->save();
      echo "Calling accept";
      $this->lp->accept();


      return "Added proposal";
    }
}
