import React, { useCallback, useEffect, useState } from "react";
import ArticleNotFound from "../Articles/ArticleNotFound";
import ArticleDetailsLoader from "../../Helpers/Loaders/ArticleDetailsLoader";
import AxiosConfig from "../../config/AxiosConfig";
import TopItemArticles from "../Articles/Templates/TopItemArticles";

export default function ResourcesViewer({
    endPoint,
    slug,
    type,
    objectKeyName,
    objectKeyValue,
    objectName,
}) {
    const [loading, setLoading] = useState(true);
    const [loadingMore, setLoadingMore] = useState(false);
    const [page, setPage] = useState(1);
    const [articles, setArticles] = useState([]);
    const [articlesMeta, setArticlesMeta] = useState([]);

    // Function to load data from a specified API endpoint based on the current page number.
    // If loading additional pages, sets loading indicator accordingly.
    // Updates state with the fetched articles and their metadata, and handles errors.
    const loadData = useCallback(() => {
        if (page > 1) setLoadingMore(true);
        AxiosConfig.get(`${endPoint}?page=${page}`)
            .then((response) => {
                setArticles((prevArticles) => [
                    ...prevArticles,
                    ...response.data.data.articles.data,
                ]);
                setArticlesMeta(response.data.data.articles.meta);
                setLoading(false);
                setLoadingMore(false);
            })
            .catch((error) => {
                setLoading(false);
                setLoadingMore(false);
                console.error(error);
            });
    }, [page, endPoint]);

    // Function to reset the page number and clear the articles state, effectively resetting the list of displayed articles.
    const resetArticles = () => {
        setPage(1);
        setArticles([]);
    };

    useEffect(() => {
        loadData();
    }, [loadData]);

    useEffect(() => {
        resetArticles();
        loadData();
    }, [slug, loadData]);

    return (
        <>
            {!loading && articles.length > 0 ? (
                <TopItemArticles
                    articles={articles}
                    itemType={type}
                    itemName={
                        objectKeyName
                            ? articles[0][objectKeyName][objectKeyValue]
                            : objectName
                    }
                    setPage={setPage}
                    page={page}
                    totalItems={articlesMeta.total}
                    perPage={articlesMeta.per_page}
                    lastPage={articlesMeta.last_page}
                    currentPage={articlesMeta.current_page}
                    loadingMore={loadingMore}
                    loadData={loadData}
                />
            ) : loading ? (
                <ArticleDetailsLoader />
            ) : (
                <ArticleNotFound />
            )}
        </>
    );
}
