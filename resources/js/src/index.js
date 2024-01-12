import React from "react";
import ReactDOM from "react-dom/client";
import App from "./App";
import reportWebVitals from "./reportWebVitals";
import { BrowserRouter } from "react-router-dom";
import { Helmet } from "react-helmet";

const root = ReactDOM.createRoot(document.getElementById("root"));

root.render(
    <BrowserRouter>
        <Helmet>
            <title>{process.env.REACT_APP_NAME}</title>
        </Helmet>
        <App />
    </BrowserRouter>
);

reportWebVitals();
