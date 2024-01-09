const getTagColorClass = (color) => {
    if (color) {
        return `bg-[${color}]`;
    }
    return 'text-gray-700';
}

export {
    getTagColorClass
}