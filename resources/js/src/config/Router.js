import React from "react";
import { Routes, Route } from "react-router-dom";
import Home from "../Pages/Home";
import NotFound from "../Pages/NotFound";

function Router(props) {
    return (
        <div className="content">
            <Routes>
                <Route path="/" element={<Home />} />
                <Route path="*" element={<NotFound />} />
            </Routes>
        </div>
    );
}

export default Router;
