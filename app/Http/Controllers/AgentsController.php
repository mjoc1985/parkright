<?php

namespace App\Http\Controllers;

use App\AgentProduct;
use App\Agents;
use Illuminate\Http\Request;

class AgentsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Agents[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return Agents::all();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Agents $agents
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       return Agents::find($id);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Agents::find($id)->update($request->all());

        return response([
            'status' => 'success',
            'msg' => 'Agent updated.'
        ]);
    }
}
