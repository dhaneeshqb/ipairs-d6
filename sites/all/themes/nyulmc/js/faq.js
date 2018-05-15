function swapImg(currentImg) {
    //alert('swap' + currentImg);
    if (currentImg.indexOf('arrow-down') > 0) {
        return currentImg.replace('arrow-down', 'arrow-close');
    }
    else {
        return currentImg.replace('arrow-close', 'arrow-down');
    }
}



$(function() {
    
    $('div.som-faq-arrow a').click(function() {
        $(this).parent().siblings('div.som-answer').toggle();
        $('#content').height("auto");
        var arrow = $(this).find('img');
        var newsrc = swapImg($(arrow).attr('src'));
        //alert(newsrc);
        $(arrow).attr('src', newsrc);
        return false;
    });
    
    $('div.som-question a').click(function() {
        $(this).parent().siblings('div.som-answer').toggle();
        $('#content').height("auto");
        var arrow = $(this).parent().siblings('div.som-faq-arrow').find('img');
        var newsrc = swapImg($(arrow).attr('src'));
        //alert(newsrc);
        $(arrow).attr('src', newsrc);
        return false;
    });
    
});