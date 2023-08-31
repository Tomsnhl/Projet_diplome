import React from "react";
import { Routes, Route } from "react-router-dom";
import Header from "../../layout/Header/Header";
import Footer from "../../layout/Footer/Footer";
import Inscription from "../../pages/Inscription/Inscription";
import Connexion from "../../pages/Connexion/Connexion";
import Hub from "../../pages/Hub/Hub";
// import Message from "../Message/Message";
// import Poll from "../Poll/Poll";
import ErrorPage from "../../pages/ErrorPage/ErrorPage";

const App: React.FC = () => {
    return (
        <>
            <Header />
            <Routes>
                {/* Page "/" d'index provisoire */}
                <Route path="/" element={<Hub />} />
                <Route path="/inscription" element={<Inscription />} />
                <Route path="/connexion" element={<Connexion />} />
                <Route path="*" element={<ErrorPage />} />
                {/* 🔽🔐 Pages authentifiées  */}
                <Route path="/hub" element={<Hub />} />
                {/* <Route path="/hub/message" element={<Message />} />
                <Route path="/hub/sondage" element={<Poll />} /> */}
            </Routes>
            <Footer />
        </>
    );
};

export default App;
