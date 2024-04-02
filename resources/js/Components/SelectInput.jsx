import {forwardRef, useEffect, useRef} from 'react';

export default forwardRef(function SelectInput({
                                                   className = '',
                                                   isFocused = false,
                                                   options = [],
                                                   placeholder,
                                                   label,
                                                   selectedValue,
                                                   ...props
                                               }, ref) {
    const selectRef = ref || useRef();

    useEffect(() => {
        if (isFocused) {
            selectRef.current.focus();
        }
    }, [isFocused]);

    const showPlaceholder = !selectedValue || selectedValue === "";

    return (
        <div className="relative">
            <select
                {...props}
                className={
                    'appearance-none border border-[#E0E0E0] rounded-[3px] text-[#BDBDBD] text-sm p-3 ' +
                    className
                }
                ref={selectRef}
                defaultValue=""
            >
                <option value="" disabled hidden></option>

                {options.map(option => (
                    <option key={option.value} value={option.value}>
                        {option.label}
                    </option>
                ))}
            </select>
            {showPlaceholder &&
                <div className="absolute top-1 pl-3 pointer-events-none flex flex-col">
                    <span className="text-[#828282] text-xs">{label}</span>
                    <span className="text-[#BDBDBD] text-sm">{placeholder}</span>
                </div>
            }
        </div>
    );
});
