<?php

namespace App\Http\Controllers\BE;

use App\Models\Customer;
use App\Models\Genitive;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GenitiveController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:genitives.list', ['only' => ['index']]);
        $this->middleware('permission:genitives.edit', ['only' => ['edit']]);
        $this->middleware('permission:genitives.add', ['only' => ['create']]);
        $this->middleware('permission:genitives.delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Quản lý nhóm tính cách';
        $genitives = Genitive::get();
        return view('genitives.index', compact('title', 'genitives'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input['name'] = 'Nhóm tính cách';
        Genitive::create($input);
        return 1;
    }

    public function getList(Request $request)
    {
        $customerId = $request->id;
        $customer = Customer::with('status')->where('id', $customerId)->first();
        $genitives = Genitive::get();

        return $data = [
            'customer' => $customer,
            'data' => $genitives
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Trademark $trademark
     * @return \Illuminate\Http\Response
     */
    public function show(Genitive $trademark)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Trademark $trademark
     * @return \Illuminate\Http\Response
     */
    public function edit(Genitive $trademark)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Trademark $trademark
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Genitive $genitive)
    {
        $genitive->update($request->all());
        return 1;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Trademark $trademark
     * @return \Illuminate\Http\Response
     */
    public function destroy(Genitive $genitive)
    {
        $genitive->delete();
    }
}
