<?php

namespace App\Http\Controllers\Api\Customers;

use App\Http\Controllers\Api\ApiController;
use App\Models\Customers\Customer;
use App\Models\Groups\WallGroup;
use App\Models\Maintainers\MaintenanceContact;
use Illuminate\Http\Request;
use Validator;

class CustomerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchCustomer = trim($request->search);
        $customers      = Customer::with(['groups', 'groups.maintainers']);
        if (!empty($searchCustomer)) {
            $customers = Customer::with(['groups', 'groups.maintainers'])->where('name', "like", "%" . $searchCustomer . "%");
        }
        $customers = $customers->paginate(2);

        if (count($customers)) {
            $this->apiData   = $customers;
            $this->apiCode   = 200;
            $this->apiStatus = true;
        } else {
            $this->apiCode    = 200;
            $this->apiStatus  = false;
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
            'name' => 'required',
        ];

        // dd($request->groups[0]);
        $validator = Validator::make($request->customer, $rules);
        if ($validator->fails()) {
            $this->apiData   = $validator->messages();
            $this->apiStatus = false;
            $this->apiCode   = 401;
        } else {
            // First we need to insert customer
            $customer = Customer::create($request->customer);
            // dd($customer);
            // dd($request->customer['wallgroups']);
            // Second we need to insert groups
            if (!is_null($request->customer['groups'])) {

                foreach ($request->customer['groups'] as $key => $group) {
                    // dd($group);
                    $group_model = new WallGroup($group);
                    $new_group   = $customer->groups()->save($group_model);

                    // Third we need to insert maintainers
                    foreach ($group['maintainers'] as $key => $maintainer) {
                        $maintainer_model = new MaintenanceContact($maintainer);
                        $new_group->maintainers()->save($maintainer_model);
                    }
                }
            }
            $this->apiData   = Customer::with(['groups', 'groups.maintainers'])->whereId($customer->id)->first();
            $this->apiStatus = true;
            $this->apiCode   = 200;
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
        $customer = Customer::with(['groups', 'groups.maintainers'])->findOrFail($id);

        if ($customer) {
            $this->apiData   = $customer;
            $this->apiCode   = 200;
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

        $customer = Customer::with(['groups', 'groups.maintainers'])->findOrFail($id);
        if ($customer) {
            $this->apiData   = $customer;
            $this->apiCode   = 200;
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
        // dd($request->customer);
        $customer_data = $request->customer;
        $rules         = [
            'name' => 'required',
        ];

        $validator = Validator::make($customer_data, $rules);
        // dd($request->groups);
        if ($validator->fails()) {
            $this->apiData   = $validator->messages();
            $this->apiStatus = false;
            $this->apiCode   = 401;
        } else {

            if (!is_null($customer_data['groups'])) {

                $customer = Customer::find($id);

                foreach ($customer_data['groups'] as $key => $group) {

                    if (isset($group['maintainers'])) {
                        $maintainers_data = $group['maintainers'];
                        unset($group['maintainers']);
                    }
                    if (isset($group['id']) && !is_null($group['id'])) {
                        $group_model = WallGroup::find($group['id']);
                        $group_model->update($group);
                    } else {
                        $group_model = new WallGroup($group);
                        $new_group   = $customer->groups()->save($group_model);
                    }
                    foreach ($maintainers_data as $key => $maintainer) {
                        if (isset($maintainer['id']) && !is_null($maintainer['id'])) {
                            $maintainer_model = MaintenanceContact::whereId($maintainer['id'])->first();
                            $maintainer_model->update($maintainer);
                        } else {
                            $maintainer_model = new MaintenanceContact($maintainer);
                            $new_maintainer   = $group_model->maintainers()->save($maintainer_model);
                        }
                    }
                }
            }

            if (isset($customer_data['groups'])) {
                unset($customer_data['groups']);
            }

            if (Customer::findOrFail($id)->update($customer_data)) {
                $this->apiData   = Customer::whereId($id)->first();
                $this->apiStatus = true;
                $this->apiCode   = 200;
            } else {
                $this->apiStatus  = false;
                $this->apiCode    = 200;
                $this->apiMessage = "Customer not found";
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
        if (Customer::whereId($id)->delete($id)) {
            $this->apiStatus = true;
            $this->apiData   = $id;
            $this->apiCode   = 200;
        } else {
            $this->apiStatus  = false;
            $this->apiCode    = 200;
            $this->apiMessage = 'Customer not found';
        }

        return $this->response();
    }
}
