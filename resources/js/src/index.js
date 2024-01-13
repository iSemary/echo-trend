import React from "react";
import ReactDOM from "react-dom/client";
import App from "./App";
import reportWebVitals from "./reportWebVitals";
import { BrowserRouter } from "react-router-dom";
import HelmetConfig from "./config/HelmetConfig";

const root = ReactDOM.createRoot(document.getElementById("root"));

root.render(
    <BrowserRouter>
        <HelmetConfig />
        <App />
    </BrowserRouter>
);

reportWebVitals();
