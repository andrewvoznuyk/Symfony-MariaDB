import {createContext, Suspense, useEffect, useMemo, useState} from "react";

import "nprogress/nprogress.css";
import "./assets/css/main.css";
import HomeBack from "./pages/home/HomeBack";


export const AppContext = createContext({});

function App() {
    const [authenticated, setAuthenticated] = useState(localStorage.getItem("token"));

    return (
        <>
            <HomeBack/>
        </>
    );
}

export default App;