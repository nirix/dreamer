jQuery(document).ready ->
    $ = jQuery
    doc = $ document

    $('.datetime-picker').each ->
        $(this).datetimepicker
            format: 'DD/MM/YYYY hh:mm A'
            icons:
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down"
                next: "fa fa-arrow-right"
                previous: "fa fa-arrow-left"

    $('[data-type=slug]').each ->
        slugField = $(this)
        target = slugField.attr('data-slug-from')

        doc.on 'blur', target, ->
            slug = $(this).val()
                .toLowerCase()
                .replace(/[^\w ]+/g, '')
                .trim()
                .replace(/ +/g, '-')

            slugField.val(slug)
