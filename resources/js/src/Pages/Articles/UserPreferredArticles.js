import React, { useEffect, useState } from "react";
import AxiosConfig from "../../config/AxiosConfig";
import TopItemArticles from "./Templates/TopItemArticles";

const UserPreferredArticles = () => {
    const [sourceArticles, setSourceArticles] = useState([]);
    const [categoryArticles, setCategoryArticles] = useState([]);
    const [authorArticles, setAuthorArticles] = useState([]);

    useEffect(() => {
        AxiosConfig.get("/preferred/articles")
            .then((response) => {
                setSourceArticles(response.data.data.articles.sources);
                setCategoryArticles(response.data.data.articles.categories);
                setAuthorArticles(response.data.data.articles.authors);
            })
            .catch((error) => {
                console.error(error);
            });
    }, []);

    return (
        <div className="top-news">
            {sourceArticles && sourceArticles.length > 0 && (
                <div className="mb-3">
                    <h4 className="mb-0 text-uppercase">
                        What sources you like wrote today
                    </h4>
                    <TopItemArticles articles={sourceArticles} />
                </div>
            )}
            {categoryArticles && categoryArticles.length > 0 && (
                <div className="mb-3">
                    <h4 className="mb-0 text-uppercase">
                        Based on your desired categories
                    </h4>
                    <TopItemArticles articles={categoryArticles} />
                </div>
            )}
            {authorArticles && authorArticles.length > 0 && (
                <div className="mb-3">
                    <h4 className="mb-0 text-uppercase">
                        Favorite authors spotlight
                    </h4>
                    <TopItemArticles articles={authorArticles} />
                </div>
            )}
        </div>
    );
};

export default UserPreferredArticles;
