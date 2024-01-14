import React, { useEffect } from "react";
import { useParams } from "react-router-dom";
import AxiosConfig from "../config/AxiosConfig";

const CategoryArticles = () => {
    const { slug } = useParams();

    useEffect(() => {
        AxiosConfig.get(`/categories/${slug}/articles`)
            .then((response) => {})
            .catch((error) => {
                console.error(error);
            });
    }, [slug]);

    return slug;
};

export default CategoryArticles;
