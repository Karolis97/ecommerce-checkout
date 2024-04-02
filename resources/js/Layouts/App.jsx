import { Outlet } from 'react-router-dom'
import Footer from "../Components/Footer.jsx";

function App() {
    return (
        <div className="App">
            <Outlet />
            <Footer />
        </div>
    )
}

export default App
