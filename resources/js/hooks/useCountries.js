import React, { useState, useEffect } from 'react';
import axios from 'axios';

const useCountries = () => {
    // State to hold the list of countries
    const [countries, setCountries] = useState([]);
    const [isLoading, setIsLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        const fetchCountries = async () => {
            try {
                const response = await axios.get('/countries');
                setCountries(response.data);
            } catch (error) {
                setError(error.message);
            } finally {
                setIsLoading(false);
            }
        };

        fetchCountries();
    }, []);

    return { countries, isLoading, error };
};

export default useCountries;
