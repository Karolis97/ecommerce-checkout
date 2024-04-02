import { useState, useEffect } from 'react';
import axios from 'axios';

const useCart = () => {
    const [cart, setCart] = useState([]);
    const [isLoading, setIsLoading] = useState(true);
    const [error, setError] = useState(null);

    const fetchCartData = async () => {
        try {
            const response = await axios.get('/cart');
            setCart(response.data);
        } catch (error) {
            setError(error.message);
        } finally {
            setIsLoading(false);
        }
    };

    useEffect(() => {
        fetchCartData();
    }, []);

    const removeFromCart = async (productId) => {
        setIsLoading(true);
        try {
            await axios.delete(`/cart/${productId}`);
            await fetchCartData();
        } catch (error) {
            setError(error.message);
        } finally {
            setIsLoading(false);
        }
    };


    return { cart, isLoading, error, removeFromCart };
};

export default useCart;
