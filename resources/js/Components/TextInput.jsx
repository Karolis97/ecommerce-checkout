import { forwardRef, useEffect, useRef } from 'react';

export default forwardRef(function TextInput({ pattern = '',type = 'text', className = '', isFocused = false, ...props }, ref) {
    const input = ref ? ref : useRef();

    useEffect(() => {
        if (isFocused) {
            input.current.focus();
        }
    }, []);

    return (
        <input
            {...props}
            type={type}
            className={
                'border border-[#E0E0E0] rounded-[3px] text-[#BDBDBD] text-sm p-3 ' +
                className
            }
            pattern={pattern}
            ref={input}
        />
    );
});
