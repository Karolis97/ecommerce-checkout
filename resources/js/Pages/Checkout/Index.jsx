import CheckoutForm from "../../Components/CheckoutForm.jsx";
import CheckoutCart from "../../Components/CheckoutCart.jsx";
import useCart from "../../hooks/useCart.js";
import Navigation from "../../Components/Navigation.jsx";


export default function CheckoutIndex() {
    const { cart, isLoading, error, removeFromCart } = useCart();

    if (isLoading) return <div>Loading...</div>;
    if (error) return <div>Error: {error}</div>;

    return (
        <div>
            <header className="md:hidden">
                <Navigation cart={cart} isLoading={isLoading} error={error} removeFromCart={removeFromCart} />
            </header>
            <div className="bg-[#F8F1EB]">
                <div className="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div className="col-span-3">
                        <div className="py-6 md:py-10 lg:py-16 px-4 max-w-3xl mx-auto">
                            <div className="text-[#333333] text-sm uppercase pb-4">Payment and Shipping</div>
                            <CheckoutForm />
                        </div>
                    </div>
                    <div className="hidden md:block col-span-2 py-20 bg-white">
                        <CheckoutCart cart={cart} isLoading={isLoading} error={error} removeFromCart={removeFromCart} />
                    </div>
                </div>
            </div>
        </div>
    );
}
