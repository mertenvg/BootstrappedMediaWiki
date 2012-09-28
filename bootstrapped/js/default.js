(function ($) {
    
    var toc = $('#toc ul:first').clone();
    
    $('body').data('target','.subnav').data('offset','50');
    
    $('#toc').replaceWith(
        $('<div />').prop('id', 'toc').addClass('well').append(toc)
    );
    
    $('a.external')
        .append('&nbsp;')
        .append(
            $('<i />').addClass('icon-share-alt icon-grey')
        );
    
    $('.editsection').each(function (i, el) {
        var editLink = $(el).find('a').clone();
        $(el).empty().append(
            $(editLink).empty().append(
                $('<i />').addClass('icon-edit icon-grey')
            )
        );
    });
    
    $('input[type=checkbox], input[type=radio]').parent().find('label').css('display','inline');
    $('input[type=button]').addClass('btn');
    $('input[type=submit]').addClass('btn btn-primary');
    
    $('.successbox').addClass('alert alert-success');
    
    $('pre').addClass('prettyprint linenums').css('border-color', '#ccc');    
    
    $('#page-content').fadeIn('fast');
    
})(jQuery);

$(function () {
    
    // make the code blocks pretty
    window.prettyPrint && prettyPrint();
    
});