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
            <div className="container mx-auto flex justify-between py-4">
                <div className="flex gap-8 items-center">
                    <ApplicationLogo />
                    {links.map((link) => (
                        <a href={link.href} className="text-sm text-white opacity-60">{link.name}</a>
                    ))}
                </div>
                <p className="text-sm text-white opacity-60">© 2022 Logoipsum. All  rights reserved</p>
            </div>
        </footer>
    );
}
