import CartImage from "../../images/cart.svg";
import ArrowTop from "../../images/arrow-top.svg";
import ArrowRight from "../../images/arrow-right.svg";
import ProductImage from "../../images/product-image.png";
import Dropdown from "./Dropdown";
import React, {useState} from "react";

export default function Navigation({ cart, isLoading, error }) {
    if (isLoading) return <div>Loading...</div>;
    if (error) return <div>Error: {error}</div>;

    const [isDropdownOpen, setIsDropdownOpen] = useState(false);
    const handleDropdownToggle = (isOpen) => {
        setIsDropdownOpen(isOpen);
    };

    return (
        <div>
            <Dropdown onToggle={handleDropdownToggle}>
                <Dropdown.Trigger>
                    <button type="button" className="flex items-center justify-between w-full px-4 py-3">
                                    <span className="flex items-center gap-4">
                                        <img src={CartImage} alt=""/>
                                        <p className="text-[#333333] uppercase font-semibold text-sm">Order summary</p>
                                        {isDropdownOpen ? (
                                            <img src={ArrowTop} alt="Arrow Top"/>
                                        ) : (
                                            <img src={ArrowRight} alt="Arrow Right"/>
                                        )}
                                    </span>
                        <span>${cart.total_price}</span>
                    </button>
                </Dropdown.Trigger>

                <Dropdown.Content>
                    <div className="space-y-4 pb-4">
                        {cart.items.map((item, index) => (
                            <div key={index} className="flex justify-between items-center border-b border-[#E0E0E0] py-6">
                                <div className="flex items-center gap-4">
                                    <img src={ProductImage} alt="" className="max-w-[58px]"/>
                                    <p className="text-sm"><span
                                        className="text-[#000000]">{item.quantity}x</span> {item.product.name}</p>
                                </div>
                                <span className="text-[#000000] text-sm">${item.total_price}</span>
                            </div>
                        ))}
                        <div className="flex justify-between items-center">
                            <span className="text-[#828282] text-base">Total</span>
                            <div className="space-x-4">
                                <span className="text-xs text-[#000000]">USD</span>
                                <span className="text-base text-[#333333] font-semibold">${cart.total_price}</span>
                            </div>
                        </div>
                    </div>
                </Dropdown.Content>
            </Dropdown>
        </div>
    );
}
