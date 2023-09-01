import "./Card.scss";
import Button from "../Button/Button";
import Message from "../Message/Message";
import Poll from "../Poll/Poll";
import { motion, AnimatePresence } from "framer-motion";
import { useState, useCallback } from "react";

// TODO fix bug layoutID isnot a number 😥

// TODO fermé la card au clavier

type CardProps = {
    title: string;
    img: string;
    id: number;
};

export const Card: React.FC<CardProps> = ({ title, img, id }) => {
    const [showBigCard, setShowBigCard] = useState<boolean>(false);

    // Affiche la Card en grand + scroll en haut de page pour le mobile
    const handleCard = useCallback(() => {
        setShowBigCard(true);
        // if (window.innerWidth < 768) {
        //     window.scrollTo({ top: 0, left: 0, behavior: "smooth" });
        // }
    }, []);

    const handleCloseCard = useCallback(() => {
        setShowBigCard(false);
        // FERME LA CARD AU CLAVIER
        // if (e.keyCode === 27) {
        //  console.log("fermé au clavier 👀");
        // setShowBigCard(false);
    }, []);

    return (
        <>
            {!showBigCard ? (
                <motion.div
                    style={{
                        backgroundImage: `url( ${img} )`,
                    }}
                    // initial={{ x: 0 }}
                    // animate={{ x: 300 }}
                    whileHover={{ scale: 1.05 }}
                    whileTap={{ scale: 0.98 }}
                    transition={{ duration: 0.2 }}
                    className="card"
                    onClick={handleCard}
                    layoutId={id.toString()}
                >
                    <Button className={"btn-primary"}>{title}</Button>
                </motion.div>
            ) : (
                <AnimatePresence>
                    <motion.div
                        style={{ flexGrow: 10 }}
                        role="dialog"
                        className="card card-open card-mobile"
                        layoutId={id.toString()}
                    >
                        {/* Ouverture de la CARD ID 1 = Message */}
                        {id === 1 ? (
                            <Message closeBigCard={handleCloseCard} />
                        ) : (
                            //  Ouverture de la CARD ID 2 = Sondage
                            id === 2 && <Poll closeBigCard={handleCloseCard} />
                        )}
                    </motion.div>
                </AnimatePresence>
            )}
        </>
    );
};

export default Card;
