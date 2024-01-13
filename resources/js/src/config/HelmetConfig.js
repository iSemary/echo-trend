import React from "react";
import { Helmet } from "react-helmet";
import appleTouch from "../assets/images/favicons/apple-touch-icon.png";
import fav32 from "../assets/images/favicons/favicon-32x32.png";
import fav16 from "../assets/images/favicons/favicon-16x16.png";
import favicon from "../assets/images/favicons/favicon.ico";
import siteManifest from "../assets/images/favicons/site.webmanifest";
import safariTab from "../assets/images/favicons/safari-pinned-tab.svg";

const HelmetConfig = () => {
    return (
        <Helmet>
            <title>{process.env.REACT_APP_NAME}</title>
            <link rel="apple-touch-icon" sizes="180x180" href={appleTouch} />
            <link rel="icon" type="image/png" sizes="32x32" href={fav32} />
            <link rel="icon" type="image/png" sizes="16x16" href={fav16} />
            <link rel="icon" type="image/x-icon" href={favicon} />
            <link rel="manifest" href={siteManifest} />
            <link rel="mask-icon" href={safariTab} color="#212428" />
            <meta name="msapplication-TileColor" content="#212428" />
            <meta name="theme-color" content="#212428"></meta>
        </Helmet>
    );
};
export default HelmetConfig;
