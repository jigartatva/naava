<?php

namespace App\Http\Controllers\Api\Maintainers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ApiController;
use App\Models\Maintainers\MaintenanceContact;
use Validator;

class MaintainerContactsController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $maintainers = MaintenanceContact::with('group')->paginate(2);
        if(count($maintainers)){
            $this->apiData = $maintainers;
            $this->apiCode = 200;
            $this->apiStatus = true;
        }else{
            $this->apiCode = 200;
            $this->apiStatus = false;
            $this->apiMessage = 'No customer found';
        }

        return $this->response();
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required'           
        ];
        

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $this->apiData = $validator->messages();
            $this->apiStatus = false;
            $this->apiCode = 401;
        }else{
            $customer = MaintenanceContact::create($request->toArray());
            $this->apiData = $customer;
            $this->apiStatus = true;
            $this->apiCode = 200;
        }

        return $this->response();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $maintainer = MaintenanceContact::findOrFail($id);

        if ($maintainer) {
            $this->apiData = $maintainer;
            $this->apiCode = 200;
            $this->apiStatus = true;
        }

        return $this->response();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $maintainer = MaintenanceContact::findOrFail($id);
        if ($maintainer) {
            $this->apiData = $maintainer;
            $this->apiCode = 200;
            $this->apiStatus = true;
        }
        return $this->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request_data = $request->maintainer;
        $rules = [
            'name' => 'required'            
        ];
        

        $validator = Validator::make($request_data, $rules);
        if ($validator->fails()) {
            $this->apiData = $validator->messages();
            $this->apiStatus = false;
            $this->apiCode = 401;
        }else{
            if (MaintenanceContact::findOrFail($id)->update($request_data)) {                
                $this->apiData = MaintenanceContact::whereId($id)->first();
                $this->apiStatus = true;
                $this->apiCode = 200;
            } else {
                $this->apiStatus = false;
                $this->apiCode = 200;
                $this->apiMessage = "Maintainer not found";
            } 
        }

        return $this->response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (MaintenanceContact::whereId($id)->delete($id)) {
            $this->apiStatus = true;
            $this->apiData = $id;
            $this->apiCode = 200;
        } else {
            $this->apiStatus = false;
            $this->apiCode = 200;
            $this->apiMessage = 'Maintainer not found';
        }

        return $this->response();
    }
}
