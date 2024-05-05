<?php

namespace App\Http\Controllers\Api;

use App\Enums\AddressType;
use App\Models\Api\Customer;
use App\Models\CustomerAddress;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\CustomerListResource;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Http\Resources\CountryResource;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request('search', false);
        $perPage = request('per_page', false);
        $sortField = request('sort_field', 'updated_at');
        $sortDirection = request('sort_direction', 'desc');
        $query = Customer::query();
        $query->orderBy($sortField, $sortDirection);
        if ($search){
            $query->where('first_name', 'like', "%{$search}%")
            ->orWHere('first_name', 'like', "%{$search}%");
        }
        return CustomerListResource::collection($query->paginate($perPage));
    }

        /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return new CustomerResource($customer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $customerData = $request->validated();
        $customerData['updated_by'] = $request->user()->id;
        $shippingData = $customerData['shipping'];
        $billingData = $customerData['billing'];

        $customer->update($customerData);

        if ($customer->shippingAddress) {
            $customer->shippingAddress->update($shippingData);
        } else {
            $shippingData['customer_id'] = $customer->user_id;
            $shippingData['type'] = AddressType::Shipping->value;
            CustomerAddress::create($shippingData);
        }
        if ($customer->billingAddress) {
            $customer->billingAddress->update($billingData);
        } else {
            $billingData['customer_id'] = $customer->user_id;
            $billingData['type'] = AddressType::Billing->value;
            CustomerAddress::create($billingData);
        }

        return new CustomerResource($customer);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return response()->noContent();

    }

    public function countries()
    {
        return CountryResource::collection(Country::query()->orderBy('name', 'asc')->get());
    }

}
