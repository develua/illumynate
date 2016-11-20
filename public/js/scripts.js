$(function()
{

    $('.menu-two-level').click(function(e)
    {
        e.preventDefault();
        $(this).parent().find('ul').toggle('show');
    });

    // search social data

    $('#btn-search').click(function(e)
    {
        if(!$('input[name=text_search]').val().length)
            e.preventDefault();
    });

    if($('input[name=text_search]').val().length)
    {
        searchFromSocial('facebook');
        searchFromSocial('instagram');
        searchFromSocial('pocket');
        searchFromSocial('pinterest');
        $('.photo-gallery, .articles-block').empty().append('<img src="../img/loader.gif" width="48"/>');
    }

    function searchFromSocial(social)
    {
        $.ajax({
            url: '/' + social + '/search',
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: 'text_search=' + $('input[name=text_search]').val(),
            success: function(data)
            {
                var photosHtml = data ? data : 'Not found photos';
                $('.' + social + '-block').empty().append(photosHtml);

                $('#blueimp-gallery, .pocket-item, .pinterest-item').trigger('initTagsInput');
            }
        });
    }

    $('#blueimp-gallery').on('slideend', function (event, index, slide)
    {
        $('#blueimp-gallery .photo-data').empty().append( $('.photo-gallery > a').eq(index).next('div').html());
    });


});