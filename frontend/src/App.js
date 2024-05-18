import {createContext, Suspense, useEffect, useMemo, useState} from "react";

import "nprogress/nprogress.css";
import "./assets/css/main.css";
import HomePage from "./pages/home/HomePage";


export const AppContext = createContext({});

function App() {
    const [authenticated, setAuthenticated] = useState(localStorage.getItem("token"));

    return (
                <HomePage/>
    );
}

export default App;