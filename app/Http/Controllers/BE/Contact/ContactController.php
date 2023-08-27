<?php

namespace App\Http\Controllers\BE\Contact;

use App\Constants\StatusCode;
use App\Helpers\Functions;
use App\Model\Contact;
use App\Models\CallCenter;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;


class ContactController extends Controller
{


    public function __construct()
    {
        $telesales = User::whereNotNull('caller_number')->where('active', StatusCode::ON)->pluck('full_name',
            'caller_number');
        $this->middleware('permission:call-center', ['only' => ['index']]);

        view()->share([
            'telesales' => $telesales,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = 'Quản lý tổng đài';

        if (!$request->start_date) {
            Functions::addSearchDateFormat($request, 'd-m-Y');
        }
        $input = $request->all();
        $docs = CallCenter::search($input);
        $answers = clone $docs;
        $answers = $answers->where('call_status', 'ANSWERED');

        $docs = $docs->paginate(StatusCode::PAGINATE_20);
        if ($request->ajax()) {
            return view('call_center.ajax', compact('docs', 'answers'));
        }
        return view('call_center.index', compact('title', 'docs', 'answers'));
    }

    public function show(Contact $contact)
    {
        return view('order.contact-pdf', compact('contact'));
    }
}
