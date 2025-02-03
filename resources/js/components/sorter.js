import { Sortable } from "sortablejs";

for (const sorter of document.querySelectorAll("[data-sorter]")) {
    const httpCallback = sorter.dataset.sorterCallback;

    new Sortable(sorter, {
        animation: 150,
        ghostClass: "sortable-ghost",
        handle: "[data-sorter-handle]",
        onEnd: (evt) => {
            let data = new FormData();

            for (const el of sorter.children) {
                if (!el.dataset.sorterItem) {
                    continue;
                }

                data.append("items[]", el.dataset.sorterItem);
            }

            fetch(httpCallback, {
                method: "post",
                credentials: "same-origin",
                headers: {
                    Accept: "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-Token": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
                body: data,
            })
                .then((res) => {
                    if (res.ok) {
                        return;
                    }

                    // TODO: Handle bad response
                })
                .catch((err) => {
                    // TODO: Show this error in the UI.
                    console.error(err);
                });
        },
    });
}
