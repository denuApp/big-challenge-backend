<?php

namespace App\Http\Controllers\Email;

use App\Http\Controllers\Controller;
use function view;

class VerifyEmailController extends Controller
{
    public function __invoke()
    {
        return view('auth.verify-email');
    }
}
