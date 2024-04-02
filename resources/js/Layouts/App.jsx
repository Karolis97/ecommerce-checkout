import { Outlet } from 'react-router-dom'
import ApplicationLogo from "../Components/ApplicationLogo.jsx";

function App() {
    return (
        <div className="App">
            <header className="md:hidden">
                <div className="container md:px-2 px-4 mx-auto">
                    <nav className="flex gap-4 justify-between">
                        <div className="flex gap-4 items-center">
                            <ApplicationLogo className="w-20 h-20 fill-current text-gray-500" />
                        </div>
                    </nav>
                </div>
            </header>
            <Outlet />
            <footer className="md:hidden">
                <div className="container mx-auto">
                    <div className="flex justify-center">
                        <ApplicationLogo className="w-20 h-20 fill-current text-gray-500" />
                    </div>
                </div>
            </footer>
        </div>
    )
}

export default App
