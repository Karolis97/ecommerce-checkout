import React, {useState, useEffect} from 'react';
import axios from 'axios';
import useCart from "../hooks/useCart.js";

export default function CheckoutCart({ cart, isLoading, error }) {
    return (
        <div className="max-w-md mx-auto px-4">
            {isLoading ? (
                <div>Loading...</div>
            ) : error ? (
                <div>Error: {error}</div>
            ) : (
                <div className="space-y-6">
                    {cart.items.map((item, index) => (
                        <div key={index} className="flex justify-between items-center border-b-2 border-[#E0E0E0] py-6">
                            <div className="flex items-center gap-8">
                                <img src="https://i.ibb.co/51GVZqV/Group-1802.png" alt="" className="max-w-[72px]"/>
                                <p className="text-base"><span
                                    className="text-[#000000] font-semibold">{item.quantity}x</span> {item.product.name}</p>
                            </div>
                            <span className="text-[#000000] text-base font-semibold">${item.total_price}</span>
                        </div>
                    ))}
                    <div className="flex justify-between items-center">
                        <span className="text-[#828282] text-lg">Total</span>
                        <div className="space-x-4">
                            <span className="text-sm text-[#000000]">USD</span>
                            <span className="text-2xl text-[#333333] font-semibold">${cart.total_price}</span>
                        </div>
                    </div>
                </div>
            )}
        </div>
    );
}
