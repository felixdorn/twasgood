export function debounce(task, ms) {
    let t = { promise: null, cancel: (_) => void 0 };
    return async (...args) => {
        try {
            t.cancel();
            t = deferred(ms);
            await t.promise;
            await task(...args);
        } catch (_) {
            // We neeed to catch this.
        }
    };
}

function deferred(ms) {
    let cancel,
        promise = new Promise((resolve, reject) => {
            cancel = reject;
            setTimeout(resolve, ms);
        });
    return { promise, cancel };
}
