<?php

namespace App\Models\Proposal;

// Basically an enum
interface ProposalType
{
    const UNSET = "";
    const EDIT = "Edit";
    const ADD = "Add";
    const DELETE = "Delete";

}
