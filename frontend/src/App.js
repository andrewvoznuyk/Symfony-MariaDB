import { Route, Routes, useLocation, useNavigate } from "react-router-dom";
import { createContext, Suspense, useEffect, useMemo, useState } from "react";
import { HelmetProvider } from "react-helmet-async";
import { CircularProgress } from "@mui/material";
import nprogress from "nprogress";
import routes from "./routes/routes";
import getUserInfo from "./utils/getUserInfo";
import eventBus from "./utils/eventBus";
import "nprogress/nprogress.css";
import "./assets/css/main.css";
import { roles } from "./utils/consts";

export const AppContext = createContext({});

function App() {
    const [authenticated, setAuthenticated] = useState(localStorage.getItem("token"));
    const location = useLocation();
    const navigate = useNavigate();
    const userInfo = getUserInfo();
    const authRouteRender = () => {
        if (!authenticated) {
            return routes.map((route, index) => (
                <Route key={index} path={route.path} element={route.element} />
            ));
        }
    };

    const handleOnIdle = () => {
        eventBus.on("logout", (data) => {
            localStorage.removeItem("clientId");
            localStorage.removeItem("token");

            setAuthenticated(false);
            navigate("/");
        });
    };

    useMemo(() => {
        nprogress.start();
    }, [location]);

    useEffect(() => {
        nprogress.done();
    }, [location]);

    useEffect(() => {
        handleOnIdle();
    }, []);

    return (
        <AppContext.Provider
            value={{
                authenticated,
                setAuthenticated,
                user: getUserInfo(),
            }}
        >
            <HelmetProvider>
                <div style={{ width: "100%", height: "100vh", boxSizing: "border-box", margin: "0 auto" }}>
                    {!authenticated && (
                            <Suspense fallback={<CircularProgress />}>

                                <Routes>{authRouteRender()}</Routes>

                            </Suspense>
                    )}
                </div>
            </HelmetProvider>
        </AppContext.Provider>
    );
}

export default App;
