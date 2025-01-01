import htmx from "htmx.org";
import Sortable from "sortablejs";

document
    .querySelectorAll(".grow-wrap > input, .grow-wrap > textarea")
    .forEach((el) => {
        el.parentNode.dataset.replicatedValue = el.value;

        el.addEventListener("input", (_) => {
            el.parentNode.dataset.replicatedValue = el.value;
        });
    });

htmx.onLoad(function (content) {
    var sortables = content.querySelectorAll(".sortable");
    for (var i = 0; i < sortables.length; i++) {
        var sortable = sortables[i];
        var inst = new Sortable(sortable, {
            animation: 150,
            ghostClass: "bg-red-500",

            filter: ".htmx-indicator",
            onMove: function (evt) {
                return evt.related.className.indexOf("htmx-indicator") === -1;
            },

            onEnd: function (evt) {
                this.option("disabled", true);
            },
        });

        sortable.addEventListener("htmx:afterSwap", function () {
            inst.option("disabled", false);
        });
    }
});
