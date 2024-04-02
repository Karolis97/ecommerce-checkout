export default function SectionDescription({ value, className = '', children}) {
    return (
        <p className={`block text-xs text-[#BDBDBD] ` + className}>
            {value ? value : children}
        </p>
    );
}
