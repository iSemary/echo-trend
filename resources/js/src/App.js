import React, { useEffect, useState } from "react";
import Router from "./config/Router";
import Header from "./Partials/Header";
import Footer from "./Partials/Footer";
import { Container } from "react-bootstrap";
import axiosConfig from "./config/AxiosConfig";
import "bootstrap/dist/css/bootstrap.min.css";
import "./assets/styles/style.css";
import { Token } from "./Helpers/Authentication/Token";

function App() {
    const [user, setUser] = useState(null);
    const [loadingUser, setLoadingUser] = useState(true);

    useEffect(() => {
        const checkToken = async () => {
            try {
                const isAuthenticated = await Token.check();
                if (isAuthenticated) {
                    const response = await axiosConfig.get("/auth/user");
                    setUser(response.data.data.user);
                }
            } catch (error) {
                console.error("Error in App useEffect:", error);
            } finally {
                setLoadingUser(false);
            }
        };
        checkToken();
    }, []);

    return (
        <Container>
            <Header user={user} loadingUser={loadingUser} />
            <Router user={user} />
            <Footer />
        </Container>
    );
}

export default App;
