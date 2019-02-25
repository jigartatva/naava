<?php

namespace App\Http\Controllers\Api\Groups;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Groups\WallGroup;
use App\Http\Controllers\Api\ApiController;
use App\Models\Maintainers\MaintenanceContact;
use Validator;

class WallGroupController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = WallGroup::with(['customer','maintainers'])->paginate(2);
        if(count($groups)){
            $this->apiData = $groups;
            $this->apiCode = 200;
            $this->apiStatus = true;
        }else{
            $this->apiCode = 200;
            $this->apiStatus = false;
            $this->apiMessage = 'No wall group found';
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
            'customer_id' => 'required'     
        ];
        

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $this->apiData = $validator->messages();
            $this->apiStatus = false;
            $this->apiCode = 401;
        }else{
            $group = WallGroup::create($request->toArray());
            $this->apiData = $group;
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $request_data = $request->group;
        $rules = [
            'name' => 'required'            
        ];
        
        $validator = Validator::make($request_data, $rules);
        if ($validator->fails()) {
            $this->apiData = $validator->messages();
            $this->apiStatus = false;
            $this->apiCode = 401;
        }else{
            $wall_group_data = WallGroup::findOrFail($id);

            if ($wall_group_data->update($request_data)) {

                if(isset($request_data['maintainers']) && !is_null($request_data['maintainers'])){

                    foreach ($request_data['maintainers'] as $key => $maintainer) {

                        if(isset($maintainer['id']) && !is_null($maintainer['id'])){
                            $maintainer_model = MaintenanceContact::whereId($maintainer['id'])->first();                            
                            $maintainer_model->update($maintainer);
                        }else{                        
                            $maintainer_model = new MaintenanceContact($maintainer);
                            $wall_group_data->maintainers()->save($maintainer_model);
                        }
                    }
                }

                $this->apiData = WallGroup::with('maintainers')->whereCustomerId($wall_group_data->customer_id)->get();
                $this->apiStatus = true;
                $this->apiCode = 200;
                
            } else {
                $this->apiStatus = false;
                $this->apiCode = 200;
                $this->apiMessage = "Group not found";
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
        if (WallGroup::whereId($id)->delete($id)) {
            $this->apiStatus = true;
            $this->apiData = $id;
            $this->apiCode = 200;
        } else {
            $this->apiStatus = false;
            $this->apiCode = 200;
            $this->apiMessage = 'Group not found';
        }

        return $this->response();
    }
}
