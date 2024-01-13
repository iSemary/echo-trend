import { toast, ToastContainer } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";

const ToastAlert = (message, type) => {
    toast[type](message, {
        position: "top-right",
        autoClose: 5000,
        hideProgressBar: false,
        closeOnClick: true,
        pauseOnHover: true,
        draggable: true,
    });
};

export { ToastAlert, ToastContainer };
