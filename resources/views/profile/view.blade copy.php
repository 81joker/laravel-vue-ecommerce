<x-app-layout>
    <div x-data="{
        countries: {{ json_encode($countries) }},
        billingAddress: {{ json_encode([
            // If have Old billing.address1 address then use it and when don't have use it  $billingAddress->address1
            'address1' => old('billing.address1' , $billingAddress->address1),
            'address2' => old('billing.address2' , $billingAddress->address2),
            'city' => old('billing.city' , $billingAddress->city),
            'state' => old('billing.state' , $billingAddress->state),
            'zipcode' => old('billing.zipcode' , $billingAddress->zipcode),
            'country_code' => old('billing.country_code' , $billingAddress->country_code),
        ]) }},
        shippingAddress: {{ json_encode([
            'address1' => old('shipping.address1' , $shippingAddress->address1),
            'address2' => old('shipping.address2' , $shippingAddress->address2),
            'city' => old('shipping.city' , $shippingAddress->city),
            'state' => old('shipping.state' , $shippingAddress->state),
            'zipcode' => old('shipping.zipcode' , $shippingAddress->zipcode),
            'country_code' => old('shipping.country_code' , $shippingAddress->country_code),
        ]) }},
        get billingCountryStates() {
            const contry = this.countries.find(c => c.code === this.billingAddress.country_code)
                if (contry && contry.states) {
                    return JSON.parse(contry.states)
                }
                    return null;
            }

        get shippingCountryStates() {
            const contry = this.countries.find(c => c.code === this.shippingAddress.country_code)
                if (contry && contry.states) {
                    return JSON.parse(contry.states)
                }
                    return null;
            }

        flashMessage: '{{ \Illuminate\Support\Facades\Session::get('success') }}',
        init() {
            if (this.flashMessage) {
                setTimeout(() => this.$dispatch('notify', {
                                message: this.flashMessage ') , 200);}
                            }
                        }" class="container mx-auto lg:w-2/3 p-5">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
            <div class="bg-white p-3 shadow rounded-lg md:col-span-2">
                <form x-data="{}"  action="route('profile.update')"  method="POST">
                    @csrf
                    <h2 class="text-xl font-semibold mb-2">Profile Details</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                        <x-text-input
                        type="text"
                        name="first_name"
                        value="{{old('first_name', $customer->first_name)}}"
                        placeholder="First Name"
                    />
                    <x-text-input
                        type="text"
                        name="last_name"
                        value="{{old('last_name', $customer->last_name)}}"
                        placeholder="Last Name"
                    />
                    </div>
                    <div class="mb-3">
                        <x-text-input
                            type="text"
                            name="email"
                            {{-- value="{{old('email', $user->email)}}" --}}
                            placeholder="Your Email"
                            />
                    </div>
                    <div class="mb-3">
                        <x-text-input
                            type="text"
                            name="phone"
                            value="{{old('phone', $customer->phone)}}"
                            placeholder="Your Phone"
                            />
                    </div>
                    <h2 class="text-xl mt-6 font-semibold mb-2">Billing Address</h2>
                    <div class="grid grid-cols-2 gap-3 mb-3">
                        <div>
                            <x-text-input
                                type="text"
                                name="billing[address1]"
                                x-model="billingAddress.address1"
                                placeholder="Address 1"
                            />
                        </div>
                        <div>
                            <x-text-input
                                type="text"
                                name="billing[address2]"
                                x-model="billingAddress.address2"
                                placeholder="Address 2"
                            />
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3 mb-3">
                        <div>
                            <x-text-input
                                type="text"
                                name="billing[city]"
                                x-model="billingAddress.city"
                                placeholder="City"
                            />
                        </div>
                        <div>
                            <x-text-input
                                type="text"
                                name="billing[zipcode]"
                                x-model="billingAddress.zipcode"
                                placeholder="ZipCode"
                            />
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3 mb-3">
                        <div>
                            <x-text-input type="select"
                                     name="shipping[country_code]"
                                     x-model="shippingAddress.country_code"
                                    >
                                <option value="">Select Country</option>
                                <template x-for="country of countries" :key="country.code">
                                    <option :selected="country.code === shippingAddress.country_code"
                                            :value="country.code" x-text="country.name"></option>
                                </template>
                            </x-text-input>
                        </div>
                        <div>
                            <template x-if="shippingCountryStates">
                                <x-text-input type="select"
                                         name="shipping[state]"
                                         x-model="shippingAddress.state"
                                        >
                                    <option value="">Select State</option>
                                    {{-- https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/entries --}}
                                    <template x-for="[code, state] of Object.entries(shippingCountryStates)"
                                              :key="code">
                                        <option :selected="code === shippingAddress.state"
                                                :value="code" x-text="state"></option>
                                    </template>
                                </x-text-input>
                            </template>
                            <template x-if="!shippingCountryStates">
                                <x-text-input
                                    type="text"
                                    name="shipping[state]"
                                    x-model="shippingAddress.state"
                                    placeholder="State"
                                    class="w-full focus:border-purple-600 focus:ring-purple-600 border-gray-300 rounded"
                                />
                            </template>
                        </div>
                    </div>

                    {{-- ST --}}
                    <div>
                        <x-text-input
                            type="text"
                            name="shipping[address2]"
                            x-model="shippingAddress.address2"
                            placeholder="Address 2"
                            class="w-full focus:border-purple-600 focus:ring-purple-600 border-gray-300 rounded"
                        />
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3 mb-3">
                    <div>
                        <x-text-input
                            type="text"
                            name="shipping[city]"
                            x-model="shippingAddress.city"
                            placeholder="City"
                            class="w-full focus:border-purple-600 focus:ring-purple-600 border-gray-300 rounded"
                        />
                    </div>
                    <div>
                        <x-text-input
                            name="shipping[zipcode]"
                            x-model="shippingAddress.zipcode"
                            type="text"
                            placeholder="ZipCode"
                            class="w-full focus:border-purple-600 focus:ring-purple-600 border-gray-300 rounded"
                        />
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3 mb-3">
                    <div>
                        <x-text-input type="select"
                                 name="shipping[country_code]"
                                 x-model="shippingAddress.country_code"
                                 class="w-full focus:border-purple-600 focus:ring-purple-600 border-gray-300 rounded">
                            <option value="">Select Country</option>
                            <template x-for="country of countries" :key="country.code">
                                <option :selected="country.code === shippingAddress.country_code"
                                        :value="country.code" x-text="country.name"></option>
                            </template>
                        </x-text-input>
                    </div>
                    <div>
                        <template x-if="shippingCountryStates">
                            <x-text-input type="select"
                                     name="shipping[state]"
                                     x-model="shippingAddress.state"
                                     class="w-full focus:border-purple-600 focus:ring-purple-600 border-gray-300 rounded">
                                <option value="">Select State</option>
                                <template x-for="[code, state] of Object.entries(shippingCountryStates)"
                                          :key="code">
                                    <option :selected="code === shippingAddress.state"
                                            :value="code" x-text="state"></option>
                                </template>
                            </x-text-input>
                        </template>
                        <template x-if="!shippingCountryStates">
                            <x-text-input
                                type="text"
                                name="shipping[state]"
                                x-model="shippingAddress.state"
                                placeholder="State"
                                class="w-full focus:border-purple-600 focus:ring-purple-600 border-gray-300 rounded"
                            />
                        </template>
                    </div>
                {{-- </div> --}}
                    {{-- END --}}

                    <x-primary-button class="w-full ">Update</x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
