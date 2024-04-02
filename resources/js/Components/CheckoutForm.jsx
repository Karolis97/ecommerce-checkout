import SectionTitle from "./SectionTitle.jsx";
import SectionDescription from "./SectionDescription.jsx";
import TextInput from "./TextInput.jsx";
import InputError from "./InputError.jsx";
import SelectInput from "./SelectInput.jsx";
import PrimaryButton from "./PrimaryButton.jsx";
import {useOrder} from "../hooks/useOrder.js";
import {formatCreditCardNumber, formatCVV, formatExpirationDate} from "../utils.js";
import SecureBadge from "./SecureBadge.jsx";
import useCountries from "../hooks/useCountries";
import {useState} from "react";
import useStatesByCountry from "../hooks/useStatesByCountry.js";

export default function CheckoutForm() {
    const { order, createOrder } = useOrder();
    const { countries, countriesLoading, countriesError } = useCountries();

    const [selectedCountry, setSelectedCountry] = useState('');
    const { states, statesLoading, statesError } = useStatesByCountry(selectedCountry);

    async function handleSubmit(event) {
        event.preventDefault()
        await createOrder(order.data)
    }

    const options = [
        { value: '1', label: 'Option 1' },
        { value: '2', label: 'Option 2' },
        // Add as many options as needed
    ];

    const handleInputChange = ({ target }) => {
        switch(target.name) {
            case 'card_number':
                target.value = formatCreditCardNumber(target.value)
                break;
            case 'card_expiry':
                target.value = formatExpirationDate(target.value)
                break;
            case 'card_cvv':
                target.value = formatCVV(target.value)
                break;
            case 'country_id':
                setSelectedCountry(target.value);
                break;
            default:
                break;
        }

        order.setData(prevData => ({
            ...prevData,
            [target.name]: target.value
        }));
    }

    return (
        <div className="bg-white border border-[#E9D6C5] rounded-md py-5 px-4">
            <form onSubmit={ handleSubmit } className="space-y-8 pb-8">
                <div className="flex flex-col space-y-1">
                    <SectionTitle>Customer Information</SectionTitle>
                    <SectionDescription>Fields marked as (*) are required.</SectionDescription>
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                        <div>
                            <TextInput
                                id="first_name"
                                type="first_name"
                                name="first_name"
                                className="mt-1 block w-full"
                                placeholder="First name*"
                                disabled={ order.loading }
                                onChange={handleInputChange}
                            />
                            <InputError errors={order.errors} field="first_name" className="mt-2" />
                        </div>

                        <div>
                            <TextInput
                                id="last_name"
                                type="last_name"
                                name="last_name"
                                className="mt-1 block w-full"
                                placeholder="Last name*"
                                disabled={ order.loading }
                                onChange={handleInputChange}
                            />
                            <InputError errors={order.errors} field="last_name" className="mt-2" />
                        </div>
                    </div>
                </div>

                <div className="flex flex-col space-y-3">
                    <SectionTitle>Shipping Address</SectionTitle>
                    <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div className="md:col-span-3">
                            <TextInput
                                id="address"
                                type="address"
                                name="address"
                                className="mt-1 block w-full"
                                placeholder="Address*"
                                disabled={ order.loading }
                                onChange={handleInputChange}
                            />
                            <InputError errors={order.errors} field="address" className="mt-2" />
                        </div>

                        <div>
                            <SelectInput
                                id="country_id"
                                name="country_id"
                                className="mt-1 block w-full"
                                placeholder="Select"
                                label="Country*"
                                disabled={order.loading || countriesLoading || countriesError}
                                options={countries}
                                selectedValue={order.data.country_id}
                                onChange={handleInputChange}
                            />

                            <InputError errors={order.errors} field="country_id" className="mt-2" />
                        </div>

                        <div>
                            <SelectInput
                                id="state_id"
                                name="state_id"
                                className="mt-1 block w-full"
                                placeholder="Select"
                                label="Region/State*"
                                disabled={order.loading || statesLoading || statesError || !selectedCountry}
                                options={states}
                                selectedValue={order.data.state_id}
                                onChange={handleInputChange}
                            />

                            <InputError errors={order.errors} field="state_id" className="mt-2" />
                        </div>

                        <div>
                            <TextInput
                                id="postal_code"
                                type="postal_code"
                                name="postal_code"
                                className="mt-1 block w-full"
                                placeholder="Postal code*"
                                disabled={ order.loading }
                                onChange={handleInputChange}
                            />
                            <InputError errors={order.errors} field="postal_code" className="mt-2" />
                        </div>
                    </div>
                </div>

                <div className="flex flex-col space-y-3">
                    <SectionTitle>Payment method</SectionTitle>

                    <div className="border border-[#F2F2F2] rounded-md divide-y divide-[#E0E0E0]">
                        <p className="text-[#333333] text-sm p-3">Credit Card</p>

                        <div className="grid grid-cols-2 lg:grid-cols-5 gap-4 bg-[#FAFAFA] p-3">
                            <div className="col-span-2 lg:col-span-5">
                                <TextInput
                                    type="tel"
                                    id="card_number"
                                    name="card_number"
                                    className="mt-1 block w-full col-span-3"
                                    placeholder="Card number"
                                    disabled={ order.loading }
                                    pattern='[\d| ]{16,22}'
                                    maxLength='19'
                                    onChange={handleInputChange}
                                />
                                <InputError errors={order.errors} field="card_number" className="mt-2" />
                            </div>

                            <div>
                                <TextInput
                                    type="tel"
                                    id="card_expiry"
                                    name="card_expiry"
                                    className="mt-1 block w-full col-span-3"
                                    placeholder="MM/YY"
                                    disabled={ order.loading }
                                    pattern='\d\d/\d\d'
                                    maxLength='19'
                                    onChange={handleInputChange}
                                />
                                <InputError errors={order.errors} field="card_expiry" className="mt-2" />
                            </div>

                            <div>
                                <TextInput
                                    type="tel"
                                    id="card_cvv"
                                    name="card_cvv"
                                    className="mt-1 block w-full col-span-3"
                                    placeholder="CVV"
                                    pattern="\d{3}"
                                    disabled={ order.loading }
                                    onChange={handleInputChange}
                                />
                                <InputError errors={order.errors} field="card_cvv" className="mt-2" />
                            </div>
                        </div>
                    </div>
                </div>

                <PrimaryButton className="mt-4" disabled={ order.loading }>
                    Complete order
                </PrimaryButton>

                <SecureBadge />
            </form>
        </div>
    );
}
