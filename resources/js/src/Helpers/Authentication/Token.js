import axios from "axios";
import Cookies from "js-cookie";

export const Token = {
    store(token) {
        // Store token in cookies
        if (token) {
            Cookies.set("AUTH_TOKEN", token, { expires: 365 * 100 });
        }
    },
    explode() {
        // Delete token from cookies
        Cookies.remove("AUTH_TOKEN");
    },
    get() {
        // Get token from cookies
        return Cookies.get("AUTH_TOKEN");
    },
    check() {
        // Check storage token is expired or not [Returns True/False]
        return new Promise((resolve, reject) => {
            axios
                .get(process.env.REACT_APP_API_URL + "/auth/check", {
                    headers: {
                        Authorization: "Bearer " + this.get(),
                    },
                })
                .then((response) => {
                    resolve(response.data.success);
                })
                .catch((error) => {
                    console.log("User not authenticated");
                    reject(false);
                });
        });
    },
};
