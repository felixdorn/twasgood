document
    .querySelectorAll(".grow-wrap > input, .grow-wrap > textarea")
    .forEach((el) => {
        el.parentNode.dataset.replicatedValue = el.value;

        el.addEventListener("input", (_) => {
            el.parentNode.dataset.replicatedValue = el.value;
        });
    });
