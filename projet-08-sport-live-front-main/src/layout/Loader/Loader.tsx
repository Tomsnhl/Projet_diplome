import "./loader.scss";
import PuffLoader from "react-spinners/PuffLoader";
const Loader: React.FC = () => {
    return <PuffLoader size={90} color={"#ecf954"} className={"loader"} />;
};
export default Loader;
