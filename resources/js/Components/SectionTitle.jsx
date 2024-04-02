export default function SectionTitle({ value, className = '', children}) {
    return (
        <p className={`block font-semibold text-sm text-[#333333] ` + className}>
            {value ? value : children}
        </p>
    );
}
