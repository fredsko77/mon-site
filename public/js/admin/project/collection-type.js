jQuery(document).ready(function() {

    $('#add-task').click(function(e) {
        var list = $($(this).attr('data-list-selector'));
        // Try to find the counter of the list or use the length of the list
        var counter = list.data('widget-counter') || list.children().length;

        // grab the prototype template
        var newWidget = list.attr('data-prototype');
        // replace the "__name__" used in the id and name of the prototype
        // with a number that's unique to your emails
        // end name attribute looks like name="contact[emails][2]"
        newWidget = newWidget.replace(/__name__/g, counter);
        // Increase the counter
        counter++;
        // And store it, the length cannot be used if deleting widgets is allowed
        list.data('widget-counter', counter);

        // Entourer le widget d'un HTML customisé
        newWidget =
            `<div class="row">
                <div class="col-11">
                    ${newWidget}
                </div>
                <div class="col-1">
                    <span class="btn btn-delete text-danger" onclick="deleteTask(event)"><i class="bi bi-x-square"></i></span>
                </div>
            </div>`;

        // create a new list element and add it to the list
        var newElem = jQuery(list.attr('data-widget-tags')).html(newWidget);

        newElem.appendTo(list);

    });


});

// Supprimer un task du DOM
deleteTask = (e) => e.target.closest('.row').remove();