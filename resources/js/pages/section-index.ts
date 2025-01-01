import { Sortable } from "sortablejs";

// Autogrow the inputs for title and description
document
    .querySelectorAll(".grow-wrap > input, .grow-wrap > textarea")
    .forEach((el) => {
        el.parentNode.dataset.replicatedValue = el.value;

        el.addEventListener("input", (_) => {
            el.parentNode.dataset.replicatedValue = el.value;
        });
    });

// Sort sections / recipes in section by drag-and-dropping the elements.
document.querySelectorAll("[data-sortable]").forEach((group) => {
    const href = group.dataset.sortableHref;
    let sortableInstance = new Sortable(group, {
        animation: 150,
        ghostClass: "sortable-ghost",

        onEnd: (evt) => {
            let data = new FormData();

            for (const el of group.children) {
                if (!el.dataset.sortValue) {
                    continue;
                }

                data.append("items[]", el.dataset.sortValue);
            }

            fetch(href, {
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
                    // handle a 422?
                })
                .catch((e) => {
                    // Here we could do more
                    console.error(e);
                });
        },
    });
});
