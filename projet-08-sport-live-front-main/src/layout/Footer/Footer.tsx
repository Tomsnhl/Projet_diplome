import { Link } from "react-router-dom";
import "./footer.scss";

const Footer: React.FC = () => {
    return (
        <footer>
            <hr />
            <nav role="navigation" aria-label="footer navigation">
                <Link to="/donnees-personnelles">Données personnelles</Link> |
                <Link to="/mentions-legales">Mentions légales</Link> |
                <Link to="/contact">Contact</Link>
            </nav>
        </footer>
    );
};

export default Footer;
