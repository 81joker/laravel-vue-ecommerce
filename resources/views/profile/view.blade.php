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

                    <button class="w-full">Update</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
