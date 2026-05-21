<?php

namespace App\Interfaces;

interface ApprovableInterface
{
    // Method public
    public function approve();
    public function reject();
}
