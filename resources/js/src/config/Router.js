import React from "react";
import { Routes, Route } from "react-router-dom";
import Home from "../Pages/Home";
import NotFound from "../Pages/NotFound";
import Register from "../Pages/Authentication/Register";
import Login from "../Pages/Authentication/Login";

function Router(props) {
    return (
        <div className="content">
            <Routes>
                <Route path="/" element={<Home />} />
                <Route path="/login" element={<Login />} />
                <Route path="/register" element={<Register />} />
                <Route path="*" element={<NotFound />} />
            </Routes>
        </div>
    );
}

export default Router;
