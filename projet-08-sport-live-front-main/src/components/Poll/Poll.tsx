import Button from "../Button/Button";
import { IoIosClose } from "react-icons/io";
import PollElement from "../PollElement/PollElement";
import "./poll.scss";
import Authentication from "../../utils/authentication/Authentication";

type PollProps = {
    closeBigCard: () => void;
};

const Poll: React.FC<PollProps> = ({ closeBigCard }) => {
    return (
        <Authentication>
            <article id="poll">
                <Button
                    type={"button"}
                    className={"close"}
                    onClick={closeBigCard}
                >
                    <span>
                        <IoIosClose />
                    </span>
                </Button>

                <h2>Posez votre question pour le sondage ?</h2>
                <ul>
                    <PollElement />
                </ul>
                <Button type={"button"} className={"btn-primary-2"}>
                    Voter
                </Button>
            </article>
        </Authentication>
    );
};
export default Poll;
