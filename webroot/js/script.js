$(document).ready(function() {

    setTimeout(function() {
        console.log('timeout');
    }, 3000);


    var $ajaxBtn = $('#ajax-btn'),
        $bookInput = $('#book-input')
    ;

    $ajaxBtn.on('click', function() {
        var value = $bookInput.val();

        var firstRequest = $.get('/api/first/' + value);

        firstRequest.then(function(r) {
            $.post('/api/second', {a: r.a}).then(function(r) {
                console.log(r);
            });
        }, function() {
            console.log('fail');
        });
    });



    var $testBtn = $('.test-button'),

        testBtnHandler = function() {
            var $this = $(this);
            var $detailsBtn = $('.details');
            $this.siblings().filter('.details').toggle();

            console.log(this, $this);
        };


    $('.books-list').on('click', '.test-button',  testBtnHandler);


    var $feedbackForm = $('.feedback-form'),
        $emailInput = $feedbackForm.find('input'),
        $textAreaInput = $feedbackForm.find('textarea'),
        $alert = $('.form-alert');

    $feedbackForm.on('submit', function(event) {
        event.preventDefault();
        var valid = $emailInput.val() != '' && $textAreaInput.val() != '';

        // if (!valid) {
        //     alert('Fill thr fields');
        //     return false;
        // }

        console.log($feedbackForm.serialize());
        $.post('/api/feedback', $feedbackForm.serialize())
            .done(function(r) {
                console.log('success', r);

                $feedbackForm.fadeOut(1000, function() {
                    $alert.removeClass('alert-danger').addClass('alert-success').text(r.message);
                    $feedbackForm.remove();
                });

            })
            .fail(function(r) {
                $alert.removeClass('alert-success').addClass('alert-danger').text(r.responseJSON.message);
                console.log('fail', r);
            })

        ;

        // console.log($feedbackForm.serializeArray());
        // console.log($emailInput.val(), $textAreaInput.val());
    });

    var $blockTemplate = $('.book-item-template'),
        $booksContainer = $('.books-list'),
        $loadMoreBtn = $('#load-books'),
        $currentPageHolder = $('#current-page-holder')
    ;

    var page = $currentPageHolder.data('page');

    $loadMoreBtn.click(function() {
        $.get('/api/books?page=' + page, function(r) {
            page++;
            $currentPageHolder.data('page', page);
            for (var k in r) {
                var book = r[k];
                var $block = $blockTemplate.clone();
                $block
                    .removeClass('book-item-template')
                    .find('.card-title')
                    .text(book.title)
                ;

                $block.find('.card-text').text(book.description);
                $block.find('.card-body a.details').attr('href', '/book/' + book.id);
                // $block.find('.test-button').on('click', testBtnHandler);
                $booksContainer.append($block);
            }
            console.log(r);
        });
    });
});