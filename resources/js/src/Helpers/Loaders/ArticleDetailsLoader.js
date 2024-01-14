import React from "react";
import ContentLoader from "react-content-loader";
import styleVariables from "../../assets/styles/variables/variables.module.scss";
import { Container } from "react-bootstrap";

const ArticleDetailsLoader = () => {
    return (
        <Container className="text-center mt-5">
            <ContentLoader
                speed={1}
                width={800}
                height={600}
                viewBox="0 0 800 600"
                backgroundColor={styleVariables.darkGrayColor}
                foregroundColor={styleVariables.lightGrayColor}
            >
                <rect x="0" y="0" rx="5" ry="5" width="800" height="300" />
                <rect x="0" y="320" rx="5" ry="5" width="800" height="20" />
                <rect x="0" y="360" rx="5" ry="5" width="800" height="20" />
                <rect x="0" y="400" rx="5" ry="5" width="800" height="20" />
                <rect x="0" y="440" rx="5" ry="5" width="800" height="20" />
                <rect x="0" y="480" rx="5" ry="5" width="800" height="20" />
            </ContentLoader>
        </Container>
    );
};

export default ArticleDetailsLoader;
