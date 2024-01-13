import axios from "axios";
import { Token } from "../Helpers/Authentication/Token";

const AxiosConfig = axios.create({
    baseURL: process.env.REACT_APP_API_URL,
    timeout: 10000,
    headers: {
        "Content-Type": "application/json",
        Authorization: "Bearer " + Token.get(),
    },
});

export default AxiosConfig;
