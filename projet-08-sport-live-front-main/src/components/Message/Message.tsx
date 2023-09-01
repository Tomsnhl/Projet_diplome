import "./message.scss";
import React, { useState, useCallback, useEffect, useRef, FC } from "react";
import Button from "../Button/Button";
import { IoIosClose } from "react-icons/io";
import { motion } from "framer-motion";
import Authentication from "../../utils/authentication/Authentication";

type IMessage = {
    closeBigCard: () => void;
};

const Message: FC<IMessage> = ({ closeBigCard }) => {
    // TODO vérifier les caractères espaces
    // TODO répeter l'animation à chaque fois que l'erreur est jouée

    const [textArea, setTextArea] = useState<string>("");

    const isWriting = (e: React.ChangeEvent<HTMLTextAreaElement>) => {
        setTextArea(e.target.value);
    };

    // Focus le form
    const textAreaElement = useRef<HTMLTextAreaElement>(null);
    useEffect(() => {
        if (textAreaElement.current) {
            textAreaElement.current.focus();
        }
    }, []);

    // Validation du formulaire (btn valider)
    const handleSubmit = (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        checkForm();
    };

    // La touche Entrée envoi le form + la touche Esc ferme la card
    const handleKeyDown = useCallback(
        (e: React.KeyboardEvent<HTMLTextAreaElement>) => {
            console.log("validtion du clavier  🦁");

            if (e.key === "Enter") {
                e.preventDefault();
                checkForm();
            }
            if (e.key === "Escape") {
                console.log("fermé au clavier 👀");
                closeBigCard();
            }
        },
        [isWriting]
    );

    // Vérification form
    const [errorForm, setErrorForm] = useState<string>("");
    const [showConfirmation, setShowConfirmation] = useState<boolean>(false);
    const checkForm = useCallback(() => {
        // Form vide
        if (textArea === "") {
            return setErrorForm("Votre message est vide");
        }
        // Form trop court
        else if (textArea.length < 3) {
            return setErrorForm("Votre message est trop court");
        }
        // => Formulaire validé
        setShowConfirmation(true);
        console.log(textArea);
    }, [handleSubmit]);

    return (
        <Authentication>
            <article id="message">
                <Button
                    type={"button"}
                    className={"close"}
                    onClick={closeBigCard}
                    ariaLabel={"Close"}
                >
                    <span>
                        <IoIosClose />
                    </span>
                </Button>
                <h2>
                    Surveillez l'écran du stade pour voir votre message
                    affiché&nbsp;!
                </h2>

                {!showConfirmation ? (
                    <form onSubmit={handleSubmit}>
                        <textarea
                            name="message-content"
                            id="message-content"
                            ref={textAreaElement}
                            placeholder="Go Spurs Go !!"
                            value={textArea}
                            onChange={isWriting}
                            onKeyDown={handleKeyDown}
                        ></textarea>
                        <motion.p
                            animate={{ x: [-15, 15, -15] }}
                            transition={{
                                repeat: 3,
                                duration: 0.2,
                                bounce: 0.6,
                            }}
                            className="errorform"
                        >
                            {errorForm}
                        </motion.p>
                        <Button type={"submit"} className={"btn-primary-2"}>
                            Valider
                        </Button>
                    </form>
                ) : (
                    <>
                        <h1>Message envoyé</h1>
                        <h3>{textArea}</h3>
                    </>
                )}
            </article>
        </Authentication>
    );
};
export default Message;
