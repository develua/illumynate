$(function()
{

    $('.menu-two-level').click(function(e)
    {
        e.preventDefault();
        $(this).parent().find('ul').toggle('show');
    });

});
