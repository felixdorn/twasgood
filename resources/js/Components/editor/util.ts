export const debounce = (cb: () => void, timeout: number) => {
    if (!window) {
        return
    }
    const timeoutId = window.setTimeout(() => {
    }, 0);
    for (let id = timeoutId; id >= 0; id -= 1) {
        window.clearTimeout(id);
    }

    setTimeout(cb, timeout);
};

export const throttle = (cb: () => void, timeout: number) => {
    let lastTime = 0;
    return () => {
        const now = Date.now();
        if (now - lastTime > timeout) {
            cb();
            lastTime = now;
        }
    };
}
