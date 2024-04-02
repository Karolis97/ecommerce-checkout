import { useState } from 'react'
import { useNavigate } from 'react-router-dom'

export function useOrder() {
    const [errors, setErrors] = useState({})
    const [loading, setLoading] = useState(false)
    const [data, setData] = useState({})
    const navigate = useNavigate()

    function createOrder(data) {
        setLoading(true)
        setErrors({})

        return axios.post('/api/order', data)
            .then(() => navigate('/'))
            .catch(error => {
                if (error.response.status === 422) {
                    setErrors(error.response.data.errors)
                }
            })
            .finally(() => setLoading(false))
    }

    console.log(data);

    return {
        order: { data, setData, errors, loading },
        createOrder,
    }
}
