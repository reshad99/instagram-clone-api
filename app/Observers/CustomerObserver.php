<?php

namespace App\Observers;

use App\Models\Customer;
use App\Models\User;
use App\Services\V1\FileProcess\FileUploaderService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class CustomerObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(Customer $customer)
    {

    }

    public function creating(Customer $customer)
    {
        $customer->password = Hash::make(request()->password);
    }

    public function updated(Customer $customer)
    {
        if (request()->has('image')) {
            $file = request()->image;
            $fileService = new FileUploaderService($file);
            $fileService->save($customer);
        }
    }
}
