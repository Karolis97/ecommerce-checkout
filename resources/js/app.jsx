import './bootstrap';

import { BrowserRouter, Routes, Route } from "react-router-dom";
import React from 'react'
import { createRoot } from 'react-dom/client';
import App from "./Layouts/App";
import CheckoutIndex from "./Pages/Checkout/Index.jsx";
import SummaryPage from "./Components/SummaryPage.jsx";

createRoot(document.getElementById('app')).render(
    <React.StrictMode>
        <BrowserRouter>
            <Routes>
                <Route path="/" element={<App />}>
                    <Route index element={<CheckoutIndex />} />
                    <Route path="/order-created" element={<SummaryPage />} />
                </Route>
            </Routes>
        </BrowserRouter>
    </React.StrictMode>,
)
