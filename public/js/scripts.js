$(function()
{
    $('input[name=search]').keyup(function(e)
    {
        if(e.keyCode == 13)
        {
            if(!$(this).val().length)
                return;

            searchRedirect();
        }
    });

    $('#btn-search').click(searchRedirect);

    function searchRedirect()
    {
        var text = $('input[name=search]').val();

        if(!text.length)
            return;

        window.location = '/search/' + text;
    }

    if(window.location.pathname == '/photos')
    {
        $('.photo-gallery, .articles-block').empty().append('<img src="../img/loader.gif" width="48"/>');
        getSocialData('facebook', 'photos', '');
        getSocialData('instagram', 'photos', '');
    }
    else if(window.location.pathname == '/articles')
    {
        $('.photo-gallery, .articles-block').empty().append('<img src="../img/loader.gif" width="48"/>');
        getSocialData('pocket', 'articles', '');
        getSocialData('pinterest', 'articles', '');
    }
    else if(window.location.pathname.indexOf('/search') > -1)
    {
        var text = window.location.pathname.split('/search/')[1];

        if(!text)
            return;

        $('.photo-gallery, .articles-block').empty().append('<img src="../img/loader.gif" width="48"/>');
        $('input[name=search]').val(text)
        var action = '/index/' + text;
        getSocialData('facebook', 'photos', action);
        getSocialData('instagram', 'photos', action);
        getSocialData('pocket', 'articles', action);
        getSocialData('pinterest', 'articles', action);
    }

    function getSocialData(provider, text, action)
    {
        $.ajax({
            url: '/' + provider + action,
            type: 'get',
            success: function(data)
            {
                var html = data ? data : 'Not found ' + text;
                $('.' + provider + '-block').empty().append(html);
                initTagsInput();
            }
        });
    }

    $('#blueimp-gallery').on('slideend', function (event, index, slide)
    {
        $('#blueimp-gallery .photo-data').empty().append($('.photo-gallery > a').eq(index).next('div').html());
    });

});