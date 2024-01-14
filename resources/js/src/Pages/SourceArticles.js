import React, { useEffect } from "react";
import { useParams } from "react-router-dom";
import AxiosConfig from "../config/AxiosConfig";

const SourceArticles = () => {
    const { slug } = useParams();

    useEffect(() => {
        AxiosConfig.get(`/sources/${slug}/articles`)
            .then((response) => {})
            .catch((error) => {
                console.error(error);
            });
    }, [slug]);

    return slug;
};

export default SourceArticles;
