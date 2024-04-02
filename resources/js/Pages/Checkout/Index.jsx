import CheckoutForm from "../../Components/CheckoutForm.jsx";
import CheckoutCart from "../../Components/CheckoutCart.jsx";
import Footer from "../../Components/Footer.jsx";


export default function CheckoutIndex() {
    return (
        <div className="bg-[#F8F1EB]">
            <div className="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div className="col-span-3">
                    <div className="py-16 px-4 max-w-3xl mx-auto">
                        <div className="text-[#333333] text-sm uppercase pb-4">Payment and Shipping</div>
                        <CheckoutForm />
                    </div>
                </div>
                <div className="col-span-2 py-20 bg-white">
                    <CheckoutCart />
                </div>
            </div>
            <Footer />
        </div>
    );
}
