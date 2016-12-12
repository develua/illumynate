$(function()
{
    switch(window.location.pathname)
    {
        case '/photos':
            lessContentItem('facebook', 'photos', 0, 25);
            lessContentItem('instagram', 'photos', 0, 25);
            getSocialData('get', 'facebook', 'photos');
            getSocialData('get', 'instagram', 'photos');
            break;
        case '/articles':
            lessContentItem('pocket', 'articles', 0, 9);
            lessContentItem('pinterest', 'articles', 0, 9);
            getSocialData('get', 'pocket', 'articles');
            getSocialData('get', 'pinterest', 'articles');
            break;
        case '/search':
            searchContent();
            break;
        case '/home':
            callAllSocialData('new-content=true');
            break;
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

        callAllSocialData('text-search=' + text);
    }

    function callAllSocialData(data)
    {
        $('.photo-gallery, .articles-block').empty().append('<img src="../img/loader.gif" width="48"/>');
        getSocialData('post', 'facebook', 'photos', data);
        getSocialData('post', 'instagram', 'photos', data);
        getSocialData('post', 'pocket', 'articles', data);
        getSocialData('post', 'pinterest', 'articles', data);
    }

    function getSocialData(method, provider, typeItem, sendData)
    {
        $.ajax({
            url: '/' + provider,
            type: method,
            headers: {
                'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
            },
            data: sendData,
            success: function(data)
            {
                if(!data)
                {
                    $('.' + provider + '-block').empty().append('Not found ' + typeItem);
                    return;
                }

                $('.' + provider + '-block').html(data);
                lessContentItem('facebook', 'photos', 0, 25);
                lessContentItem('instagram', 'photos', 0, 25);
                lessContentItem('pocket', 'articles', 0, 9);
                lessContentItem('pinterest', 'articles', 0, 9);

                initTagsInput();
                $('.pagination li').removeClass('disabled');
            }
        });
    }

    function lessContentItem(provider, typeItem, start, end)
    {
        if(typeItem == 'photos')
            $('.' + provider + '-block .content-item').hide().slice(start, end).show();
        else
            $('.' + provider + '-block .' + provider + '-item').hide().slice(start, end).show();
    }

    $('.panel-body').on('click', '.pagination a', function(e)
    {
        if($(this).parent().hasClass('disabled'))
        {
            e.preventDefault();
            return;
        }

        var parent = $(this).parents('ul');
        var provider = $(this).parents('ul').attr('data-provider');
        var typeItem = (provider == 'facebook' || provider == 'instagram') ? 'photos' : 'articles';
        var numElement = (typeItem == 'photos') ? 25 : 9;
        var numPages = parseInt(parent.find('li[data-num-page]:last').text());
        var btnText = $(this).text();
        var btnNum = parseInt(btnText);
        $btnActive = parent.find('li[class=active]');

        if($btnActive.find('a').text() == btnText)
            return;

        if(btnText == '«')
        {
            if(btnNum == 1)
                return;

            $btnActive.prev().addClass('active');
            btnNum--;
        }
        else if(btnText == '»')
        {
            if(btnNum == numPages)
                return;

            $btnActive.next().addClass('active');
            btnNum++;
        }
        else
            $(this).parents('li').addClass('active');

        var start = btnNum * numElement - numElement;
        var end = btnNum * numElement;
        lessContentItem(provider, typeItem, start, end);

        $btnActive.removeClass('active');

        if(numPages > 5)
        {
            // show 5 active button
            start = (btnNum > 3) ? (btnNum < numPages - 2 ? btnNum - 3 : numPages - 5) : 0;
            end = (btnNum > 3) ? btnNum + 2 : start + 5;
            parent.find('li[data-num-page]').hide().slice(start, end).show();
        }

    });

    $('#blueimp-gallery').on('slideend', function (event, index, slide)
    {
        $('#blueimp-gallery .photo-data').empty().append($('.photo-gallery .content-item').eq(index).find('.photo-caption').html());
    });

});