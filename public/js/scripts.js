$(function()
{
    var soialContent = new Array();

    if(window.location.pathname == '/photos')
    {
        $('.photo-gallery, .articles-block').empty().append('<img src="../img/loader.gif" width="48"/>');
        getSocialData('get', 'facebook', 'photos', '');
        getSocialData('get', 'instagram', 'photos', '');
    }
    else if(window.location.pathname == '/articles')
    {
        $('.photo-gallery, .articles-block').empty().append('<img src="../img/loader.gif" width="48"/>');
        getSocialData('get', 'pocket', 'articles', '');
        getSocialData('get', 'pinterest', 'articles', '');
    }
    else if(window.location.pathname == '/search')
    {
        searchContent();
    }

    $('#btn-search').click(function(e)
    {
        if(window.location.pathname != '/search')
            return;

        e.preventDefault();
        searchContent();
    });

    $('input[name=text-search]').keyup(function(e)
    {
        if(e.keyCode == 13)
        {
            if(window.location.pathname != '/search')
                return;

            e.preventDefault();
            searchContent();
        }
    });

    function searchContent()
    {
        var text = $('input[name=text-search]').val();

        if(!text.length)
            return;

        $('.photo-gallery, .articles-block').empty().append('<img src="../img/loader.gif" width="48"/>');
        getSocialData('post', 'facebook', 'photos', text);
        getSocialData('post', 'instagram', 'photos', text);
        getSocialData('post', 'pocket', 'articles', text);
        getSocialData('post', 'pinterest', 'articles', text);
    }

    function getSocialData(method, provider, typeItem, text)
    {
        var data = (text.length) ? 'text-search=' + text : '';

        $.ajax({
            url: '/' + provider,
            type: method,
            headers: {
                'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
            },
            data: data,
            success: function(data)
            {
                if(!data)
                {
                    $('.' + provider + '-block').empty().append('Not found ' + typeItem);
                    return;
                }

                $wrap = $('<div></div>').append(data);

                soialContent[provider] = {
                    pageIndex: 0,
                    html: $wrap.find('.content-item, .pinterest-item, .pocket-item')
                };

                showContent(provider);
            }
        });
    }

    function showContent(provider)
    {
        var numElement = 25;
        var content = soialContent[provider];
        var numPages = Math.ceil(content.html.length / numElement);
        var btnActive = (numPages > 5) ? content.pageIndex + 1 : content.pageIndex;

        // add pagination
        $pagination = $('<div><ul class="pagination" data-provider="' + provider + '"></ul></div>');

        for(var i = 0; i < numPages; i++)
            $pagination.find('ul').append('<li><a href="#">' + (i + 1)+ '</a></li>');

        if(numPages > 5)
        {
            // show 5 active button
            var start = (content.pageIndex > 2) ? (content.pageIndex < numPages - 2 ? content.pageIndex - 2 : numPages - 5) : 0;
            var end = (content.pageIndex > 2) ? content.pageIndex + 3 : start + 5;
            $pagination.find('li').hide().slice(start, end).show();

            // add arrow
            $pagination.find('ul').prepend('<li><a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>');
            $pagination.find('ul').append('<li><a href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>');
        }

        $pagination.find('li').eq(btnActive).addClass('active');

        // show content
        start = (content.pageIndex + 1) * numElement - numElement;
        end = (content.pageIndex + 1) * numElement;
        $elements = content.html.slice(start, end);

        // add content
        $block = $('.' + provider + '-block').empty().append($elements);

        // show pagination
        if(numPages > 1)
            $block.append($pagination)

        initTagsInput();
    }

    $('.panel-body').on('click', '.pagination a', function(e)
    {
        e.preventDefault();

        var numElement = 25;
        var provider = $(this).parents('ul').attr('data-provider');
        var content = soialContent[provider];
        var numPages = Math.ceil(content.html.length / 25);
        var btnContent = $(this).text();

        if(btnContent == '«')
            (content.pageIndex > 0) ? content.pageIndex-- : false;
        else if(btnContent == '»')
            (content.pageIndex < numPages - 1) ? content.pageIndex++ : false;
        else
            content.pageIndex  = parseInt(btnContent) - 1;

        showContent(provider);
    });


    $('#blueimp-gallery').on('slideend', function (event, index, slide)
    {
        $('#blueimp-gallery .photo-data').empty().append($('.photo-gallery .content-item').eq(index).find('.photo-caption').html());
    });

});