import Button from "../Button/Button";
import React, { useCallback, useContext, useState } from "react";
import { ConnectedContext } from "../../utils/context/ConnectedProvider";
import { Link } from "react-router-dom";
import Popup from "reactjs-popup";
import { IoIosClose } from "react-icons/io";
import "./deconnexion.scss";

const Deconnexion: React.FC = () => {
    const { logout } = useContext(ConnectedContext);

    const [open, setOpen] = useState<boolean>(false);
    const closeModal = useCallback(() => setOpen(false), []);

    return (
        <>
            <Button
                type={"button"}
                className={"bn-secondary"}
                onClick={() => setOpen((o) => !o)}
            >
                Déconnexion
            </Button>
            <Popup open={open} closeOnDocumentClick onClose={closeModal}>
                <div className="modal">
                    <h2>Etes vous sur de vouloir vous déconnecter&nbsp;?</h2>
                    <Button
                        type={"button"}
                        className={"close"}
                        ariaLabel={"Close"}
                        onClick={closeModal}
                    >
                        <span>
                            <IoIosClose />
                        </span>
                    </Button>
                    <div id="popin-deco">
                        <Button
                            type={"button"}
                            className={"btn-secondary"}
                            onClick={closeModal}
                        >
                            Non
                        </Button>
                        <Button
                            type={"button"}
                            className={"btn-primary-2"}
                            onClick={logout}
                        >
                            <Link to="/">Oui</Link>
                        </Button>
                    </div>
                </div>
            </Popup>
        </>
    );
};
export default Deconnexion;
