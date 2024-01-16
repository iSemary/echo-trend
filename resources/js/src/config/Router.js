import React from "react";
import { Routes, Route } from "react-router-dom";
import ScrollToTop from "../Helpers/Utilities/ScrollToTop";
import Home from "../Pages/Home";
import NotFound from "../Pages/NotFound";
import Register from "../Pages/Authentication/Register";
import Login from "../Pages/Authentication/Login";
import Profile from "../Pages/Profile";
import CategoryArticles from "../Pages/CategoryArticles";
import AuthorArticles from "../Pages/AuthorArticles";
import SourceArticles from "../Pages/SourceArticles";
import Search from "../Pages/Search";
import { ArticleDetails } from "../Pages/ArticleDetails";
import TodayArticles from "../Pages/TodayArticles";

function Router({ user }) {
    return (
        <div className="content">
            <ScrollToTop />
            <Routes>
                <Route path="/" element={<Home />} />
                <Route path="/login" element={<Login />} />
                <Route path="/register" element={<Register />} />
                <Route path="/profile" element={<Profile />} />

                <Route
                    path="/categories/:slug/articles"
                    element={<CategoryArticles />}
                />
                <Route
                    path="/authors/:slug/articles"
                    element={<AuthorArticles />}
                />
                <Route
                    path="/sources/:slug/articles"
                    element={<SourceArticles />}
                />

                <Route path="/today" element={<TodayArticles />} />

                <Route
                    path="/articles/:sourceSlug/:slug"
                    element={<ArticleDetails />}
                />

                <Route path="/search" element={<Search />} />

                <Route path="*" element={<NotFound />} />
            </Routes>
        </div>
    );
}

export default Router;
