<?php

namespace App\Http\Controllers\BE;

use App\Constants\StatusCode;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Element;
use App\Models\Rule;

class RuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Automation';
        $docs = Rule::orderBy('id', 'desc');
        $docs = $docs->paginate(10);
        return view('rules.index', compact('docs', 'title', 'total'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Automation';
        $elements = Element::all();
        return view('rules._form', compact('elements','title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only(['id', 'title', 'start_at', 'end_at', 'configs', 'status']);
        if (!$request->has('status')) {
            $data['status'] = 0;
        }
        if (!empty($data['id'])) {
            $rule = Rule::find($data['id']);
            if (!empty($rule)) {
                $rule->update($data);
            }
        } else {
            $rule = new Rule($data);
            $rule->save();
        }
        return redirect('rules');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $elements = Element::all();
        $rule = Rule::find($id);
        return view('rules._form', compact(['elements', 'rule']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
