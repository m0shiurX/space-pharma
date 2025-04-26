<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;


class CustomerController extends Controller
{
    public function index()
    {
        return Inertia::render('Customers/Index', [
            'filters' => Request::only('search'),
            'customers' => Customer::orderBy('created_at', 'desc')
                ->filter(Request::only('search'))
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($customers) => [
                    'id' => $customers->id,
                    'name' => $customers->name,
                    'address' => $customers->address,
                    'phone' => $customers->phone,
                    'created_at' => Carbon::parse($customers->created_at)->format('M d, Y'),
                ]),
        ]);
    }

    public function create()
    {
        return Inertia::render('Customers/Create');
    }

    public function store(StoreCustomerRequest $request)
    {
        Customer::create($request->validated());
        return Redirect::route('customers.index')->with('success', 'Customer created.');
    }

    public function show(Customer $customer)
    {
        return Inertia::render('Customers/Show', [
            'customer' => [
                'id' => $customer->id,
                'name' => $customer->name,
                'address' => $customer->address,
                'phone' => $customer->phone,
            ]
        ]);
    }

    public function edit(Customer $customer)
    {
        return Inertia::render('Customers/Edit', [
            'customer' => [
                'id' => $customer->id,
                'name' => $customer->name,
                'address' => $customer->address,
                'phone' => $customer->phone,
            ]
        ]);
    }

    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $customer->update($request->validated());
        return Redirect::route('customers.index')->with('success', 'Successfully updated.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return Redirect::route('customers.index')->with('success', 'Successfully deleted.');
    }
}
