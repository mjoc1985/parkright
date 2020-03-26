<?php

namespace App\Http\Controllers;

use App\AgentProduct;
use Illuminate\Http\Request;

class AgentsProductsController extends Controller
{
    public function index($id)
    {
        return AgentProduct::where('agent_id', $id)->with('product')->get();
    }
    public function show($id)
    {
        return AgentProduct::find($id)->load('product');
    }

    public function store(Request $request)
    {
        AgentProduct::create($request->all());

        return response([
            'status' => 'Success.',
            'msg' => 'Product created.'
        ]);
    }
    public function update(Request $request, $id)
    {
        AgentProduct::find($id)->update($request->except('product'));

        return response([
            'status' => 'Success.',
            'msg' => 'Product created.'
        ]);
    }

}
