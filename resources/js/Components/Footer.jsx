import ApplicationLogo from "./ApplicationLogo.jsx";

export default function Footer() {
    const links = [
        {
            name: "Terms of Service",
            href: "#",
        },
        {
            name: "Privacy Policy",
            href: "#",
        },
        {
            name: "Returns",
            href: "#",
        },
        {
            name: "FAQ",
            href: "#",
        }
    ]
    return (
        <footer className="bg-[#DC624E]">
            <div className="container mx-auto flex flex-col lg:flex-row lg:justify-between py-4 gap-4">
                <div className="flex flex-col lg:flex-row lg:items-center gap-4 lg:gap-8">
                    <ApplicationLogo className="mx-auto" />
                    <div className="flex items-center gap-4 lg:gap-8 mx-auto">
                        {links.map((link, index) => (
                            <a key={index} href={link.href} className="text-sm text-white opacity-60">{link.name}</a>
                        ))}
                    </div>
                </div>
                <p className="text-sm text-white opacity-60 text-center lg:text-right">© 2022 Logoipsum. All  rights reserved</p>
            </div>
        </footer>
    );
}
