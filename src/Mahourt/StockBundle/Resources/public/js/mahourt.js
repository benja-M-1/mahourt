$(function () {
    $(".collapse").collapse();

    var jqxhr,
        $search,
        $add;

    $search = $('#search');
    $add = $('<button/>', {
        'type': 'submit',
        'class': 'btn',
        'text': $search.data('new-button-content')
    }).hide();
    $search.after($add);

    $search.typeahead({
        matcher: function (item) {
            return ~item.toLowerCase().indexOf(this.query.toLowerCase()) ||
                ~item.toLowerCase().indexOf($search.data('add-message').toLowerCase());
        },
        source: function (query, process) {
            // Abort pending request
            if (typeof jqxhr !== "undefined") {
                jqxhr.abort();
                jqxhr = null;
            }

            jqxhr = $.get(
                $search.data('url'),
                { 'q': query },
                function (data) {
                    if (_.isEmpty(data) || (_.isArray(data) && data.length == 0)) {
                        $add.show();
                    }
                    return process(data);
                },
                'json'
            );

            // Print a Twitter Bootstrap alert in case of error.
            jqxhr.error(function () {
                if (jqxhr.statusText === 'abort') {
                    return;
                }

                var $closeButton,
                    $alert;

                $closeButton = $('<button/>', {
                    type: "button",
                    "class": "close",
                    "data-dismiss": "alert",
                    "text": '×'
                });

                $alert = $('<div/>', { "class": "alert alert-block alert-error fade in" })
                    .prepend($closeButton)
                    .append('<h4 class="alert-heading">' + jqxhr.statusText + '</h4>')
                    .appendTo('body')
                ;

                $alert.alert();

                // Close the alert in 6 seconds
                setTimeout(function () {
                    $alert.alert('close');
                }, 6000)
            });
        }
    });
});
