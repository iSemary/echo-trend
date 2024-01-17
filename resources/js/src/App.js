import React, { useEffect, useState } from "react";
import Router from "./config/Router";
import Header from "./Partials/Header";
import Footer from "./Partials/Footer";
import { Container } from "react-bootstrap";
import AxiosConfig from "./config/AxiosConfig";
import "bootstrap/dist/css/bootstrap.min.css";
import "./assets/styles/style.css";
import { Token } from "./Helpers/Authentication/Token";

function App() {
    const [user, setUser] = useState(null);
    const [categories, setCategories] = useState([]);
    const [sources, setSources] = useState([]);
    const [loadingUser, setLoadingUser] = useState(true);

    useEffect(() => {
        const checkToken = async () => {
            try {
                const isAuthenticated = await Token.check();
                if (isAuthenticated) {
                    const response = await AxiosConfig.get("/auth/user");
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

    useEffect(() => {
        // TODO use redux
        AxiosConfig.get("/categories")
            .then((response) => {
                setCategories(response.data.data.categories);
            })
            .catch((error) => {
                console.error(error);
            });
        AxiosConfig.get("/sources")
            .then((response) => {
                setSources(response.data.data.sources);
            })
            .catch((error) => {
                console.error(error);
            });
    }, []);

    return (
        <Container>
            <Header
                user={user}
                categories={categories}
                sources={sources}
                loadingUser={loadingUser}
            />
            <Router user={user} />
            <Footer categories={categories} />
        </Container>
    );
}

export default App;
