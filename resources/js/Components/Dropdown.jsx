import { useState, createContext, useContext, Fragment } from 'react';
import { Transition } from '@headlessui/react';

const DropDownContext = createContext();

const Dropdown = ({ children, onToggle }) => {
    const [open, setOpen] = useState(false);

    const toggleOpen = () => {
        setOpen((previousState) => {
            const newState = !previousState;
            if (onToggle) {
                onToggle(newState);
            }
            return newState;
        });
    };

    return (
        <DropDownContext.Provider value={{ open, setOpen, toggleOpen, onToggle }}>
            <div className="relative">{children}</div>
        </DropDownContext.Provider>
    );
};

const Trigger = ({ children }) => {
    const { open, setOpen, toggleOpen, onToggle } = useContext(DropDownContext);

    return (
        <>
            <div onClick={toggleOpen}>{children}</div>

            {open && (
                <div className="fixed inset-0 z-40" onClick={() => { setOpen(false); onToggle(false); }}></div>
            )}
        </>
    );
};

const Content = ({ align = 'right', width = 'full', contentClasses = 'py-1 bg-white px-4 border-t border-[#E0E0E0]', children }) => {
    const { open, setOpen } = useContext(DropDownContext);

    let alignmentClasses = 'origin-top';

    if (align === 'left') {
        alignmentClasses = 'ltr:origin-top-left rtl:origin-top-right start-0';
    } else if (align === 'right') {
        alignmentClasses = 'ltr:origin-top-right rtl:origin-top-left end-0';
    }

    let widthClasses = '';

    if (width === 'full') {
        widthClasses = 'w-full';
    }

    return (
        <>
            <Transition
                as={Fragment}
                show={open}
                enter="transition ease-out duration-200"
                enterFrom="opacity-0 scale-95"
                enterTo="opacity-100 scale-100"
                leave="transition ease-in duration-75"
                leaveFrom="opacity-100 scale-100"
                leaveTo="opacity-0 scale-95"
            >
                <div
                    className={`absolute z-50 shadow-lg ${alignmentClasses} ${widthClasses}`}
                    onClick={() => setOpen(false)}
                >
                    <div className={contentClasses}>{children}</div>
                </div>
            </Transition>
        </>
    );
};

Dropdown.Trigger = Trigger;
Dropdown.Content = Content;

export default Dropdown;
