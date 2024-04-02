import { useState, useEffect } from 'react';
import axios from 'axios';

const useCart = () => {
    const [cart, setCart] = useState([]);
    const [isLoading, setIsLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
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

        fetchCartData();
    }, []);

    return { cart, isLoading, error };
};

export default useCart;
