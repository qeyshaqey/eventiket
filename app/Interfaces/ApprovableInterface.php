<?php

namespace App\Interfaces;

interface ApprovableInterface
{
    public function approve();
    public function reject();
}
