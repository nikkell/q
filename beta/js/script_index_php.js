if(/iPhone|iPad|iPod|Android/i.test(navigator.userAgent)){
    $(".accordion-container").on("click", function(){
        if($('#about').prop('checked')) {
            document.querySelectorAll(".social-icons").forEach(elem => elem.style.display = "none");
        } else {
            document.querySelectorAll(".social-icons").forEach(elem => elem.style.display = "block");
        }
});

$('nav input, .nav textarea').focus(function() {
        $('#block').hide();
    }).blur(function() {
        $('#block').show();
    });
}

$(".close-reg").on("click", function() {
    document.querySelector('.overlay2').classList.remove('overlay2');
});

$(".disable_block444as").on("click", function() {
    document.querySelector('.profile-dialog444as').classList.remove('disabled');
});

$(".close-exit444as").on("click", function() {
    document.querySelector('.profile-dialog444as').classList.add('disabled');
});

$(".disable_block444as2").on("click", function() {
    document.querySelector('.profile-dialog444as2').classList.remove('disabled');
});

$(".close-exit444as").on("click", function() {
    document.querySelector('.profile-dialog444as2').classList.add('disabled');
});

$(".accordion-container").on("click", function() {
    if($('#about').prop('checked')) {
        document.querySelectorAll(".accordion-tab header").forEach(elem => elem.style.display = "block");
        $('.accordion-tab header a').fadeIn(1000);
    } else {
        document.querySelectorAll(".accordion-tab header").forEach(elem => elem.style.display = "none");
        $('.accordion-tab header a').fadeOut(1000);
    }
});

$(".close-acordeon-mob a").on("click", function() {
    $("#main").prop("checked", true);
    $("#about").prop("checked", false);
});

$(".main-container").mouseout(function() {
    $("#main").prop("checked", true);
    $("#about").prop("checked", false);
});

$(".accordion-tab-ofset").mouseout(function() {
    $("#main").prop("checked", true);
    $("#about").prop("checked", false);
});

$(".login-input").on("click", function() {
    $("#modalform").attr("action", "index.php");
    $("#button-form-modal").attr("name", "do_login");
    $("#two_pass").removeAttr("required","");
    $("#cbx").removeAttr("required","");
    document.querySelectorAll(".check").forEach(elem => elem.style.display = "none");
    document.querySelectorAll(".disable_block444as33").forEach(elem => elem.style.display = "none");
});

$(".signup-input").on("click", function() {
    $("#modalform").attr("action", "index.php");
    $("#button-form-modal").attr("name", "do_signup");
    $("#two_pass").attr("required","");
    $("#cbx").attr("required","");
    document.querySelectorAll(".check").forEach(elem => elem.style.display = "block");
    document.querySelectorAll(".disable_block444as33").forEach(elem => elem.style.display = "block");
});

$(".social-account-okay").on("click", function() {
    document.querySelectorAll(".nav").forEach(elem => elem.style.right = "0");
    document.querySelectorAll(".nav").forEach(elem => elem.style.boxShadow = "0 0 2px black");
});

$(".inf,.close-nav").on("click", function() {
    $('.nav').attr('style', '');
});

$('.accordeon_target').click(function() {
    if (!$(this).data('status')) {
        $('.table-carousel').attr('style', 'overflow-y: hidden;');
        $('.nno').attr('style', 'display: block;');
        $(this).data('status', true);
    } else {
        $('.table-carousel').attr('style', 'overflow-y: auto;');
        $('.nno').attr('style', 'display: none;');
        $(this).data('status', false);
    }
});

$(".header-chert").on("click", function() {
    $('.input').attr('style', 'display: block');
    $('.header-chert').attr('style', 'display: none');
});

$(".table-carousel").mouseover(function() {
    $('.input').attr('style', '');
    $('.header-chert').attr('style', '');
});

// Акордион в модуле
$('.profile-avatar').click(function() {
    if (!$(this).data('status')) {
        $('.profile-bio').attr('style', 'display: block;');
        $(this).data('status', true);
    } else {
        $('.profile-bio').attr('style', 'display: none;');
        $(this).data('status', false);
    }
});
// //Акордион в модуле


$("#nextCarousel").click(function() {
    $(".main-container .table-carousel").animate({
        scrollTop: $('.main-container .table-carousel').scrollTop() + 480
    }, 0);
    $('.main-container .table-carousel').fadeOut(0);
    $('.main-container .table-carousel').fadeIn(200);
});

$("#prevCarousel").click(function() {
    $(".main-container .table-carousel").animate({
        scrollTop: $('.main-container .table-carousel').scrollTop() - 480
    }, 0);
    $('.main-container .table-carousel').fadeOut(0);
    $('.main-container .table-carousel').fadeIn(200);
});


$('.js-open-modal').click(function(event) {
    event.preventDefault();

    var modalName = $(this).attr('data-modal');
    var modal = $('.js-modal[data-modal="' + modalName + '"]');

    modal.addClass('is-show');
    $('.js-modal-overlay').addClass('is-show');
});

$('.js-modal-close').click(function() {
    $(this).parent('.js-modal').removeClass('is-show');
    $('.js-modal-overlay').removeClass('is-show');
});

$('.js-modal-overlay').click(function() {
    $('.js-modal.is-show').removeClass('is-show');
    $(this).removeClass('is-show');
})

// Фильтр
document.addEventListener('animationstart', function (e) {
    if (e.animationName === 'fade-in') {
        e.target.classList.add('did-fade-in');
    }
});

document.addEventListener('animationend', function (e) {
    if (e.animationName === 'fade-out') {
        e.target.classList.remove('did-fade-in');
    }
});

// https://github.com/joshaven/string_score
String.prototype.score = function (word, fuzziness) {

    'use strict';

    // If the string is equal to the word, perfect match.
    if (this === word) { return 1; }

    //if it not a perfect match and is empty return 0
    if (word === "") { return 0; }

    var runningScore = 0,
        charScore,
        finalScore,
        string = this,
        lString = string.toLowerCase(),
        strLength = string.length,
        lWord = word.toLowerCase(),
        wordLength = word.length,
        idxOf,
        startAt = 0,
        fuzzies = 1,
        fuzzyFactor,
        i;

    // Cache fuzzyFactor for speed increase
    if (fuzziness) { fuzzyFactor = 1 - fuzziness; }

    // Walk through word and add up scores.
    // Code duplication occurs to prevent checking fuzziness inside for loop
    if (fuzziness) {
        for (i = 0; i < wordLength; i+=1) {
            // Find next first case-insensitive match of a character.
            idxOf = lString.indexOf(lWord[i], startAt);

            if (idxOf === -1) {
                fuzzies += fuzzyFactor;
            } else {
                if (startAt === idxOf) {
                // Consecutive letter & start-of-string Bonus
                charScore = 0.7;
                } else {
                charScore = 0.1;

                // Acronym Bonus
                // Weighing Logic: Typing the first character of an acronym is as if you
                // preceded it with two perfect character matches.
                if (string[idxOf - 1] === ' ') { charScore += 0.8; }
                }

                // Same case bonus.
                if (string[idxOf] === word[i]) { charScore += 0.1; }

                // Update scores and startAt position for next round of indexOf
                runningScore += charScore;
                startAt = idxOf + 1;
            }
        }
    } else {
        for (i = 0; i < wordLength; i+=1) {
            idxOf = lString.indexOf(lWord[i], startAt);
            if (-1 === idxOf) { return 0; }

        if (startAt === idxOf) {
            charScore = 0.7;
        } else {
            charScore = 0.1;
            if (string[idxOf - 1] === ' ') { charScore += 0.8; }
        }
        if (string[idxOf] === word[i]) { charScore += 0.1; }
            runningScore += charScore;
            startAt = idxOf + 1;
        }
    }

    // Reduce penalty for longer strings.
    finalScore = 0.5 * (runningScore / strLength    + runningScore / wordLength) / fuzzies;

    if ((lWord[0] === lString[0]) && (finalScore < 0.85)) {
        finalScore += 0.15;
    }

    return finalScore;
};

// http://ejohn.org/apps/livesearch/jquery.livesearch.js
jQuery.fn.liveUpdate = function(list) {
    list = jQuery(list);

    if (list.length) {
        var rows = list.children('li'),
        cache = rows.map(function() {
            return this.innerHTML.toLowerCase();
        });

        this
        .keyup(filter).keyup()
        .parents('form').submit(function() {
            return false;
        });
    }

    return this;

    function filter() {
        var term = jQuery.trim(jQuery(this).val().toLowerCase()),
        scores = [];

        if (!term) {
            rows.show();
        } else {
            rows.hide();
            cache.each(function(i) {
                var score = this.score(term);
                if (score > 0) {
                scores.push([score, i]);
                }
            });

            jQuery.each(scores.sort(function(a, b) {
                return b[0] - a[0];
            }), function() {
                jQuery(rows[this[1]]).show();
            });
        }
    }
};

$("#search").liveUpdate("#colors");

// Поиск

const input = document.querySelector('.input');

document.body.addEventListener('click', (e) => {
    if (!searchadffff.contains(e.target) && input.value.length === 0) {
        searchadffff.classList.remove('active');
        searchadffff.classList.remove('searchadffffing');
        input.value = '';
    }
});

input.addEventListener('keyup', (e) => {
    if (e.keyCode === 13) {
        input.blur();
    }
});

input.addEventListener('input', () => {
    if (input.value.length > 0) {
        searchadffff.classList.add('searchadffffing');
    } else {
        searchadffff.classList.remove('searchadffffing');
    }
});

input.value = '';
input.blur();


$(document).on('mouseover', '.tooltip', function(event){
    var obj = $(this)
    obj.html("Договор публичный оферты<br><br>Настоящий договор между владельцем сайта в сети интернет Гаврилова Никиты Александровича и пользователем услуг сайта в сети интернет,  именуемым в дальнейшем «Покупатель» определяет условия приобретения услуги через сайт http://qvinciy.ru  Настоящий договор – оферта действует с 01 Августа 2019 года.<br><br>                                       1. ОБЩИЕ ПОЛОЖЕНИЯ <br><br>                                          1.1. Владелец сайта в сети интернет публикует настоящий договор, являющийся публичным договором - офертой (предложением) в адрес физических и юридических лиц в соответствии со ст. 435 и пунктом 2 статьи 437 Гражданского Кодекса Российской Федерации (далее - ГК РФ).")        
})
$(document).on('mouseout', '.tooltip', function(event){
    var obj = $(this)
    obj.html("Договор публичный оферты<br><br>Настоящий договор между владельцем сайта в сети интернет Гаврилова Никиты Александровича и пользователем услуг сайта в сети интернет,  именуемым в дальнейшем «Покупатель» определяет условия приобретения услуги через сайт http://qvinciy.ru  Настоящий договор – оферта действует с 01 Августа 2019 года.")        
})

$(document).on('mouseover', '.tooltip1', function(event){
    var obj = $(this)
    obj.html("Пользовательское соглашение<br><br>Настоящее Пользовательское соглашение регулирует отношения между пользователем сети Интернет (далее - Пользователь) и владельцем сайта в сети интернет http://qvinciy.ru, возникающие при использовании интернет-ресурса http://qvinciy.ru, на условиях, указанных в Пользовательском соглашении. Безоговорочным и полным принятием Пользователем положений настоящего Пользовательского соглашения является совершение действий Пользователем, которые направлены на использование Сайта, включая, но не ограничиваясь: подача, просмотр, оплата услуг, участие в рейтинге, направление сообщений Администрации сайта, и иные действия по использованию функциональности Сайта.")        
})
$(document).on('mouseout', '.tooltip1', function(event){
    var obj = $(this)
    obj.html("Пользовательское соглашение<br><br>Настоящее Пользовательское соглашение регулирует отношения между пользователем сети Интернет (далее - Пользователь) и владельцем сайта в сети интернет  http://qvinciy.ru, возникающие при использовании интернет-ресурса http://qvinciy.ru, на условиях,  указанных в Пользовательском соглашении.Безоговорочным и полным принятиемПользователем положений настоящего.<br><br><br><br><br><br>")        
})