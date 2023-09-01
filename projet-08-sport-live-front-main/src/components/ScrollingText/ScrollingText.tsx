import "./scrollingtext.scss";
import { useState, useRef, useEffect } from "react";
import { motion } from "framer-motion";

//  TODO : Durée d'affichage des msg en fonction de la longueur du tableau

interface IMesssage {
    id: number;
    content: string;
}

const ScrollingText: React.FC = () => {
    const [displayMessage, setDisplayMessage] = useState<IMesssage[]>([]);

    const token: string | null = localStorage.getItem("token");

    useEffect(() => {
        allMessagesFetch();
    }, []);

    const allMessagesFetch = async () => {
        try {
            const response = await fetch(
                `${import.meta.env.VITE_API_BASE_URL}/messages`,
                { headers: { Authorization: `bearer ${token}` } }
            );
            const result = await response.json();
            console.log(result);
            setDisplayMessage(result);
        } catch (error) {
            console.error("❌ Erreur ❌");
        }
    };

    // Calcul la longueur de l'écran en px
    const [windowSize, setWindowSize] = useState<number>(0);
    useEffect(() => {
        const windowsWidth = window.innerWidth;
        setWindowSize(windowsWidth);
    }, []);

    // Calcul la longueur du msg en px
    const [divMessageWidth, setDivMessageWidth] = useState<number>(0);
    const messageElement = useRef<HTMLDivElement>(null);
    useEffect(() => {
        const messageSize = messageElement.current?.getBoundingClientRect();
        if (messageSize) {
            setDivMessageWidth(Math.round(messageSize.width));
        }
    }, [displayMessage]);

    return (
        <>
            <div id="scrolling">
                <motion.div
                    className="scrolling-text"
                    style={{ marginRight: `-${divMessageWidth}px` }}
                    animate={{
                        transform: `translate3d(-${
                            windowSize + divMessageWidth
                        }px,0,0)`,
                    }}
                    transition={{
                        repeat: Infinity,
                        duration: 40,
                        ease: "linear",
                    }}
                    ref={messageElement}
                >
                    {displayMessage.map((message) => (
                        <span key={message.id}>{message.content}</span>
                    ))}
                </motion.div>
            </div>
        </>
    );
};
export default ScrollingText;
