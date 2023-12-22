import React, { useEffect, useState } from "react";
import Usuari from "./Usuari";
import Reserva from "./Reserva";

const Layout = ({ user, status, missatge }) => {
    const pathname = window.location.pathname;
    const [flashMessage, setFlashMessage] = useState(null);
    const [showFlashMessage, setShowFlashMessage] = useState(false);

    let contentComponent;
    if (pathname === "/") {
        contentComponent = <Usuari />;
    } else if (pathname === "/demanar-hora") {
        contentComponent = <Reserva user={user} />;
    } else {
        contentComponent = <Usuari />;
    }

    useEffect(() => {
        if (pathname === "/demanar-hora") {
            setShowFlashMessage(false);
        }
        // Mostra el missatge flash
        if (status && missatge) {
            setShowFlashMessage(true);
            setFlashMessage({ status, missatge });

            // Esborra el missatge després d'un temps determinat
            const timeoutId = setTimeout(() => {
                setShowFlashMessage(false);
                setFlashMessage(null);
            }, 5000); // Ajusta el temps segons les teves necessitats

            return () => clearTimeout(timeoutId);
        }
    }, [status, missatge]);

    return (
        <div className="flex flex-col h-screen">
            <header className="py-4 px-6 flex justify-end">
                <a
                    href="/login"
                    className="text-[#161A30] hover:text-[#B6BBC4] font-black transition-colors duration-500"
                >
                    Login
                </a>
            </header>
            <main className="flex-grow flex flex-col items-center justify-center mx-4 sm:mx-8 text-center">
                {showFlashMessage && (
                    <div
                        className={
                            status === "success"
                                ? "bg-green-300 text-black font-black p-3 pt-5 mb-3 rounded-md relative"
                                : status === "error"
                                ? "bg-red-300 text-black font-black p-3 pt-5 mb-3 rounded-md relative"
                                : null
                        }
                    >
                        <button
                            className="absolute top-0 right-2 cursor-pointer"
                            onClick={() => setShowFlashMessage(false)}
                        >
                            x{" "}
                        </button>
                        {flashMessage.missatge}
                    </div>
                )}
                <h1 className="text-gray-300 text-6xl mb-36 font-black">
                    Perruqueria Cirviànum
                </h1>
                {contentComponent}
                <span className="text-xs text-gray-200 mb-24">
                    Foto d'
                    <a
                        href="https://unsplash.com/es/@awcreativeut?utm_content=creditCopyText&utm_medium=referral&utm_source=unsplash"
                        className="text-white font-semibold"
                    >
                        Adam Winger
                    </a>{" "}
                    a{" "}
                    <a
                        href="https://unsplash.com/es/fotos/mujer-sosteniendo-secador-de-pelo-WXmHwPcFamo?utm_content=creditCopyText&utm_medium=referral&utm_source=unsplash"
                        className="text-white font-semibold"
                    >
                        Unsplash
                    </a>
                </span>
            </main>
        </div>
    );
};

export default Layout;
