// import React from "react";
import ReactDOM from "react-dom/client";
import App from "./components/App/App.tsx";
import "./assets/styles/index.scss";
import { BrowserRouter } from "react-router-dom";
import ConnectedProvider from "./utils/context/ConnectedProvider.jsx";

ReactDOM.createRoot(document.getElementById("root")!).render(
    <BrowserRouter>
        <ConnectedProvider>
            <App />
        </ConnectedProvider>
    </BrowserRouter>
);
