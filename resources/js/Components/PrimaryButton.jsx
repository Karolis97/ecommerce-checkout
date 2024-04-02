export default function PrimaryButton({ className = '', disabled, children, ...props }) {
    return (
        <button
            {...props}
            className={
                `py-4 w-full bg-[#009900] shadow-md border border-transparent rounded-[3px] text-xs text-white uppercase tracking-widest transition ease-in-out duration-150 ${
                    disabled && 'opacity-25'
                } ` + className
            }
            disabled={disabled}
        >
            {children}
        </button>
    );
}
