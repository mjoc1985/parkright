<?php

namespace App\Http\Controllers;

use App\AgentProduct;
use App\Agents;
use Illuminate\Http\Request;

class AgentsController extends Controller
{
    public function all()
    {
        return Agents::all();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Agents $agents
     * @return \Illuminate\Http\Response
     */
    public function show(Agents $agents)
    {
        //
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
    
    public function getProducts($id)
    {
        return AgentProduct::where('agent_id', $id)->with('product')->get();
    }
    public function getProduct($id)
    {
        return AgentProduct::find($id)->load('product');
    }
    
    public function saveProduct(Request $request)
    {
        $product = AgentProduct::create($request->all());
        return response([
            'status' => 'Success.',
            'msg' => 'Product created.'
        ]);
    }
    public function updateProduct(Request $request, $id)
    {
         AgentProduct::find($id)->update($request->except('product'));
        
        return response([
            'status' => 'Success.',
            'msg' => 'Product created.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Agents $agents
     * @return \Illuminate\Http\Response
     */
    public function destroy(Agents $agents)
    {
        //
    }
}
