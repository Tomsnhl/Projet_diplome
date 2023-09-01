import { useContext } from "react";
import { Link } from "react-router-dom";
import { ConnectedContext } from "../../utils/context/ConnectedProvider";
import LogoSportLive from "../../assets/img/sport-live.png";
import Deconnexion from "../../components/Deconnexion/Deconnexion";
import "./header.scss";

const Header: React.FC = () => {
    const { connected } = useContext(ConnectedContext);

    return (
        <>
            <header>
                <nav
                    role="navigation"
                    aria-label="main navigation"
                    className={connected ? "connected" : ""}
                    // Erreur TS avec le ternaire dessous
                    // className={connected && "connected"}
                >
                    <div>
                        <Link to="/">
                            <img src={LogoSportLive} alt="" />
                        </Link>
                        <Link to="/">
                            <p>Sport Live</p>
                        </Link>
                    </div>
                    {connected && <Deconnexion />}
                </nav>
            </header>
        </>
    );
};

export default Header;
