export function debounce<T extends Function>(cb: T, wait: number) {
    let h = 0;
    let callable = (...args: any) => {
        clearTimeout(h);
        h = setTimeout(() => cb(...args), wait);
    };
    return <T>(<any>callable);
}

export const throttle = (cb: () => void, timeout: number) => {
    let lastTime = 0;
    return () => {
        const now = Date.now();
        if (now - lastTime > timeout) {
            cb();
            lastTime = now;
        }
    };
};
