import React from "react";
import Usuari from "./Usuari";
import Reserva from "./Reserva";
import background from "../../../public/images/background_low.webp";

const Layout = (props) => {
    const pathname = window.location.pathname;

    let contentComponent;
    if (pathname === "/") {
        contentComponent = <Usuari />;
    } else if (pathname === "/demanar-hora") {
        contentComponent = <Reserva user={props.user} />;
    } else {
        contentComponent = <Usuari />;
    }

    return (
        <div
            className="flex flex-col h-screen"
            // style={{ opacity: 0.9 }}
        >
            {/* <div
                className="h-[200vh] absolute inset-0 z-[-1]"
                style={{
                    margin: 0,
                    backgroundImage: `url(${background})`,
                    backgroundSize: "cover",
                    backgroundRepeat: "no-repeat",
                    backgroundAttachment: "fixed",
                    minHeight: "100vh",
                    display: "flex",
                    opacity: 0.2,
                    height: "100vh", // Set height to 100vh
                }}
            ></div> */}
            <header className="py-4 px-6 flex justify-end">
                <a
                    href="/login"
                    className="text-[#161A30] hover:text-[#B6BBC4] font-black transition-colors duration-500"
                >
                    Login
                </a>
            </header>
            <main className="flex-grow flex flex-col items-center justify-center mx-4 sm:mx-8 text-center">
                <h1 className="text-gray-300 text-6xl mb-36 font-black">
                    Perruqueria Cirviànum
                </h1>
                {contentComponent}
                <span className="text-xs text-gray-200 mb-0">
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
