<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Proposals\SchoolProposal;

use App\Models\Pending\Proposal;


class ProposalController extends Controller
{
    public function __construct(SchoolProposal $sp)
    {
      $this->p = $sp;
    }

    public function index()
    {
      $this->p->create_new(1, "Lexington Again", 1245);
      $a= $this->p->accept();
      $this->p->load_by_id(37);
      $id = $this->p->accept();

      echo "Added id: " + $id;
    }
}
