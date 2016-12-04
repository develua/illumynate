$('#blueimp-gallery, .pocket-item, .pinterest-item')
    .on('DOMNodeInserted', 'input[name=tags]', initTagsInput);

function initTagsInput()
{
    $('#blueimp-gallery, .pocket-item, .pinterest-item').find('input[data-role=tagsinput]').tagsinput({
        confirmKeys: [13],
        maxTags: 10,
        maxChars: 20,
        trimValue: true
    });
    $('#blueimp-gallery, .pocket-item, .pinterest-item')
        .find('input[name=tags]')
        .on('itemAdded', saveTags)
        .on('itemRemoved', saveTags);
}

function saveTags()
{
    $tagsInput = $(this).parent().find('input[name=tags]');

    $.ajax({
        url: '/tags/update',
        type: 'post',
        contentType: "application/json; charset=utf-8",
        headers: {
            'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
        },
        data: JSON.stringify({
            content_id: $tagsInput.attr('data-content-id'),
            provider: $tagsInput.attr('data-provider'),
            tags: $tagsInput.val(),
        })
    });

    $('input[data-content-id="' + $tagsInput.attr('data-content-id') + '"]').attr('value', $tagsInput.val());
}