document.fonts.ready.then(function () {
    for (const el of document.querySelectorAll("[data-field-autosizing]")) {
        if (el.nodeName === "INPUT") {
            fitInput(el);
            el.addEventListener("input", (e) => fitInput(e.target));
        } else if (el.nodeName === "TEXTAREA") {
            el.style.resize = "none";
            el.style.height = el.scrollHeight + "px";
            el.style.overflowY = "hidden";

            el.addEventListener("input", (e) => fitTextarea(e.target));
        } else {
            throw new Error(
                `Node ${el.nodeName} can not be fitted automatically.`,
            );
        }
    }
});

function fitInput(el) {
    let stub = document.createElement("span");
    let computed = getComputedStyle(el);

    stub.innerText = el.value;
    stub.style.height = "0";
    stub.style.overflow = "hidden";
    stub.style.whiteSpace = "pre";
    stub.style.fontSize = computed.fontSize;
    stub.style.fontFamily = computed.fontFamily;
    stub.style.fontWeight = computed.fontWeight;

    document.body.appendChild(stub);

    let width =
        stub.offsetWidth +
        parseFloat(computed.paddingLeft) +
        parseFloat(computed.paddingRight) +
        parseFloat(computed.borderLeftWidth) +
        parseFloat(computed.borderRightWidth);

    el.style.width = width + "px";

    document.body.removeChild(stub);
}

function fitTextarea(el) {
    el.style.height = "auto";
    el.style.height = el.scrollHeight + "px";
}
