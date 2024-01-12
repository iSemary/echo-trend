import React from "react";
import Router from "./config/Router";
import Header from "./Partials/Header";
import Footer from "./Partials/Footer";
import "bootstrap/dist/css/bootstrap.min.css";
import "./assets/styles/style.css";
import { Container } from "react-bootstrap";

function App() {
    return (
        <Container>
            <Header />
            <Router />
            <Footer />
        </Container>
    );
}

export default App;
