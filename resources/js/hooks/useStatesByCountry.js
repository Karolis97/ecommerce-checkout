import { useState, useEffect } from 'react';
import axios from 'axios';
import useCountries from "./useCountries.js";

const useStatesByCountry = (countryId) => {
    const [states, setStates] = useState([]);
    const [isLoading, setIsLoading] = useState(false);
    const [error, setError] = useState(null);

    useEffect(() => {
        if (!countryId) {
            setStates([]);
            return; // Exit early if no countryId is provided
        }

        const fetchStates = async () => {
            setIsLoading(true);
            setError(null);
            try {
                const response = await axios.get(`/countries/${countryId}/states`);
                setStates(response.data); // Assuming the API returns an array of states
            } catch (error) {
                console.error('Failed to fetch states:', error);
                setError(error);
            } finally {
                setIsLoading(false);
            }
        };

        fetchStates();
    }, [countryId]);

    return { states, isLoading, error };
};

export default useStatesByCountry;
