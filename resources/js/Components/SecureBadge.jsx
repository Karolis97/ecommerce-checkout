import Comodo from "../../images/Comodo.svg";
import VeriSign from "../../images/VeriSign.svg";
import McAfee from "../../images/McAfee.svg";
import NortonSecure from "../../images/NortonSecure.svg";

export default function SecureBadge() {
    const secureImages = [NortonSecure, VeriSign, McAfee, Comodo];

    return (
        <div className="flex justify-center items-center gap-1">
             {secureImages.map((ImageSrc, index) => (
                 <img key={index} src={ImageSrc} alt={`Secure Badge ${index}`} />
             ))}
        </div>
    );
}
