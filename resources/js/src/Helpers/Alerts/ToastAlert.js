import { toast, ToastContainer } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";
// Function to display a toast alert with a specified message and type of the alert.
// Parameters include the message content and the type of alert (e.g., "success", "error", "info").
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
