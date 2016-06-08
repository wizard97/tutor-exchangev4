<?php
namespace App\Repositories\Proposals;

interface ProposalContract
{
    public function find($pid);
    public function create($uid, $args);
    public function save();
    public function accept();
    public function reject();
    public function validate();
    public function parent();
    public function children();
    public function is_accepted();
    public function is_saved();
}
