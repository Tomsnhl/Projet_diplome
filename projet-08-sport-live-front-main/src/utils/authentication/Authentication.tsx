import { Navigate } from "react-router-dom";
import { ConnectedContext } from "../context/ConnectedProvider";
import { useCallback, useContext, ReactNode } from "react";

interface AuthenticationProps {
    children: ReactNode;
}

const Authentication: React.FC<AuthenticationProps> = ({ children }) => {
    const { setConnected } = useContext(ConnectedContext);

    const isConnected = useCallback(() => {
        const token = localStorage.getItem("token");
        return !!token;
    }, []);

    if (isConnected()) {
        setConnected(true);
        return children;
    } else {
        setConnected(false);
        return <Navigate to="/connexion" />;
    }
};
export default Authentication;
