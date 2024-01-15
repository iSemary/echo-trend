import React, { useEffect, useState } from "react";
import { useParams } from "react-router-dom";
import AxiosConfig from "../config/AxiosConfig";
import TopItemArticles from "./Articles/Templates/TopItemArticles";
import ArticleNotFound from "./Articles/ArticleNotFound";
import ArticleDetailsLoader from "../Helpers/Loaders/ArticleDetailsLoader";

const CategoryArticles = () => {
    const { slug } = useParams();
    const [loading, setLoading] = useState(true);
    const [page, setPage] = useState(1);
    const [articles, setArticles] = useState([]);

    useEffect(() => {
        loadMoreData(page);
    }, [slug, page]);

    const loadMoreData = (nextPage) => {
        AxiosConfig.get(`/categories/${slug}/articles?page=${nextPage}`)
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
                    itemType={"Category"}
                    itemName={articles.data[0]["category"]["title"]}
                    totalItems={articles.total}
                    currentPage={page}
                    perPage={articles.per_page}
                />
            )}
        </>
    );
};

export default CategoryArticles;
