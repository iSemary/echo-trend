import React, { useCallback, useEffect, useState } from "react";
import ArticleDetailsLoader from "../../Helpers/Loaders/ArticleDetailsLoader";
import AxiosConfig from "../../config/AxiosConfig";
import SearchResults from "../Articles/Templates/SearchResults";

export default function SearchResultViewer({ endPoint, keyword }) {
    const [loading, setLoading] = useState(true);
    const [loadingMore, setLoadingMore] = useState(false);
    const [page, setPage] = useState(1);
    const [articles, setArticles] = useState([]);
    const [articlesMeta, setArticlesMeta] = useState([]);

    const [dateOrder, setDateOrder] = useState("DESC");
    const [category, setCategory] = useState("");
    const [source, setSource] = useState("");

    const loadData = useCallback(() => {
        if (page > 1) {
            setLoadingMore(true);
        }

        if (page === 1) {
            setLoading(true);
        }

        AxiosConfig.get(`${endPoint}&page=${page}&date_order=${dateOrder}`)
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
        }, [page, dateOrder, endPoint]);

    const resetArticles = () => {
        setPage(1);
        setArticles([]);
    };

    useEffect(() => {
        loadData();
    }, [loadData]);

    return (
        <>
            {!loading ? (
                <SearchResults
                    keyword={keyword}
                    articles={articles}
                    setPage={setPage}
                    page={page}
                    totalItems={articlesMeta.total}
                    perPage={articlesMeta.per_page}
                    lastPage={articlesMeta.last_page}
                    currentPage={articlesMeta.current_page}
                    loadingMore={loadingMore}
                    loadData={loadData}
                    dateOrder={dateOrder}
                    setDateOrder={setDateOrder}
                    category={category}
                    setCategory={setCategory}
                    source={source}
                    setSource={setSource}
                    resetArticles={resetArticles}
                />
            ) : (
                <ArticleDetailsLoader />
            )}
        </>
    );
}
