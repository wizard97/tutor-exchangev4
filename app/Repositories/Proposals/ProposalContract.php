<?php
namespace App\Repositories\Proposals;

interface ProposalContract
{
    public function load_by_id($pid);
    public function save();
    public function accept();
    public function reject();
    public function validate();
    public function dependencies();
    public function is_edit();
    public function is_saved();
}
