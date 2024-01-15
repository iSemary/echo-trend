import React, { useEffect, useState } from "react";
import AxiosConfig from "../config/AxiosConfig";
import TopItemArticles from "./Articles/Templates/TopItemArticles";
import ArticleNotFound from "./Articles/ArticleNotFound";
import ArticleDetailsLoader from "../Helpers/Loaders/ArticleDetailsLoader";

const TodayArticles = () => {
    const [loading, setLoading] = useState(true);
    const [page, setPage] = useState(1);
    const [articles, setArticles] = useState([]);

    useEffect(() => {
        loadMoreData(page);
    }, [page]);

    const loadMoreData = (nextPage) => {
        AxiosConfig.get(`/today?page=${nextPage}`)
            .then((response) => {
                setArticles(response.data.data.articles);
                setLoading(false);
            })
            .catch((error) => {
                setLoading(false);
                console.error(error);
            });
    };

    if (loading) {
        return <ArticleDetailsLoader />;
    }

    if (!articles.data || articles.data.length === 0) {
        return <ArticleNotFound />;
    }

    return (
        <>
            {articles.data && articles.data.length > 0 && (
                <TopItemArticles
                    articles={articles.data}
                    itemType={"Today"}
                    itemName={articles.data[0]["category"]["title"]}
                    totalItems={articles.total}
                    currentPage={page}
                    perPage={articles.per_page}
                />
            )}
        </>
    );
};

export default TodayArticles;
