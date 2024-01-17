import React from "react";
import SearchResultViewer from "./PagesTemplate/SearchResultViewer";

const Search = () => {
    const queryParameters = new URLSearchParams(window.location.search);
    const keyword = queryParameters.get("keyword");
    const category = queryParameters.get("category");
    const source = queryParameters.get("source");
    const selectedDate = queryParameters.get("date");

    return (
        <SearchResultViewer
            endPoint={`/search?keyword=${keyword}&category_id=${category}&source_id=${source}&date=${selectedDate}`}
            keyword={keyword}
            objectName={`${keyword} Search Results`}
        />
    );
};

export default Search;
