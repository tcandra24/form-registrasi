<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TermConditionController extends Controller
{
    public function index() {
        return view('participant.term-condition.index');
    }
}
