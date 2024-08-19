<?php

namespace App\Http\Controllers\Admin\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Participant;

class ParticipantController extends Controller
{
    public function index()
    {
        $participants = Participant::paginate(10);

        return view('admin.transactions.participants.index', ['participants' => $participants]);
    }
}
