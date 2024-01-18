import React, { useEffect, useState } from "react";
import SearchResultViewer from "./PagesTemplate/SearchResultViewer";
import { useLocation } from "react-router-dom";

const Search = () => {
    const [endPoint, setEndPoint] = useState("");
    const [keyword, setKeyword] = useState("");

    const location = useLocation();

    useEffect(() => {
        const queryParameters = new URLSearchParams(location.search);
        const keyword = queryParameters.get("keyword");
        const category = queryParameters.get("category");
        const source = queryParameters.get("source");
        const selectedDate = queryParameters.get("date");

        const endpoint = `/search?keyword=${keyword}&category_id=${category}&source_id=${source}&date=${selectedDate}`;
        setEndPoint(endpoint);
        setKeyword(keyword);
    }, [location.search]);

    return (
        <SearchResultViewer
            endPoint={endPoint}
            keyword={keyword}
            objectName={`${keyword} Search Results`}
        />
    );
};

export default Search;
