import { Outlet } from 'react-router-dom'
import Footer from "../Components/Footer.jsx";
import Navigation from "../Components/Navigation.jsx";

function App() {
    return (
        <div className="App">
            <Outlet />
            <Footer />
        </div>
    )
}

export default App
