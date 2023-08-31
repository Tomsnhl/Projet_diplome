import "./Event.scss";

export const Event: React.FC = () => {
    return (
        <>
            <main id="event">
                <div>
                    <h1>Meeting de Paris</h1>
                </div>

                <div className="description_event">
                    <p>
                        <span>27/05/23</span> - <span>19h</span> -&nbsp;
                        <span>Paris</span>
                    </p>
                </div>
            </main>
        </>
    );
};

export default Event;
