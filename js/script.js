$(document).ready(function () {
    // Login section
    $(".login").click(() => {
        $("#login").css({ "display": "flex" })

    })

    $(".closelogin").click(() => {
        $("#login").css({ "display": "none" })
        $("#emaillogin").val("")
        $("#pswlogin").val("")

    })
    $(".register").click(() => {
        $("#signIn").css({ "display": "flex" })

    })

    $(".closeregister").click(() => {
        $("#signIn").css({ "display": "none" })
        $("#firstname").val("")
        $("#lastname").val("")
        $("#birthday").val("")
        $("#city").val("")
        $("#cPsw").val("")
        $("#email").val("")
        $("#psw").val("")

    })

    $('#loginForm').submit(function (event) {
        event.preventDefault();

        let email = $('#emaillogin').val();
        let psw = $('#pswlogin').val();
        let btn = $('#loginBtn').attr('name');
        $.ajax({
            url: 'http://localhost/W-PHP-501-MAR-1-1-mymeetic-adonai.ouisol/welcome',
            type: 'POST',
            data: { email: email, psw: psw, login: btn },
            success: function (response) {
                if (response.success) {
                    $("#responseMessage").text("Login succesfully")
                    $("#responseMessage").css({ "color": "green" })
                    $("#responseMessage").show()
                    window.location.href = 'profile';
                } else {
                    $("#responseMessage").text("Email or password incorrect")
                    $("#responseMessage").css({ "color": "red" })
                    $("#responseMessage").show()

                }
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });

    });


    // Filter section
    $('#filterForm').submit(function (event) {
        event.preventDefault();

        let city = $('#city').val();
        let gender = $('#gender').val();
        let btn = $('#filterBtn').attr('name');
        let age = $("#ageRange").val()
        let filters = {}
        if ($("#dance").prop("checked")) {
            filters.dance = $("#dance").val()
        } else {
            filters.dance = ''
        }
        if ($("#skateboard").prop("checked")) {
            filters.skateboard = $("#skateboard").val()
        } else {
            filters.skateboard = ''
        }
        if ($("#manga").prop("checked")) {
            filters.manga = $("#manga").val()
        } else {
            filters.manga = ''
        }
        if ($("#game").prop("checked")) {
            filters.gameplay = $("#game").val()
        } else {
            filters.gameplay = ''
        }
        if ($("#cuisiner").prop("checked")) {
            filters.cuisiner = $("#cuisiner").val()
        } else {
            filters.cuisiner = ''
        }
        if ($("#firstTranche").prop("checked")) {
            filters.age = $("#firstTranche").val()
        }
        if ($("#secondTranche").prop("checked")) {
            filters.age = $("#secondTranche").val()
        }
        if ($("#thirdTranche").prop("checked")) {
            filters.age = $("#thirdTranche").val()
        }
        if ($("#lastTranche").prop("checked")) {
            filters.age = $("#lastTranche").val()
        }
        if (city != "") {
            filters.city = city
        }
        if (gender != "") {
            filters.gender = gender
        }
        filters.filter = btn

        $.ajax({
            url: 'http://localhost/W-PHP-501-MAR-1-1-mymeetic-adonai.ouisol/',
            type: 'POST',
            data: filters,
            success: function (response) {

                $('#cards').empty();
                response.forEach(function (user) {
                    let cardDiv = $('<div>').addClass('card');
                    let leftDiv = $('<div>').addClass('left');
                    let image = $('<img>').attr('src', './assets/img.jpeg').attr('alt', '');
                    leftDiv.append(image);

                    let rightDiv = $('<div>').addClass('right');

                    let userInfoTopDiv = $('<div>').addClass('userInfoTop');
                    let nameHeading = $('<h2>').text(user.firstname + ' ' + user.lastname);
                    let birthday = new Date(user.birthday);
                    let ageDiffMs = Date.now() - birthday.getTime();
                    let ageDate = new Date(ageDiffMs);
                    let age = Math.abs(ageDate.getUTCFullYear() - 1970);
                    let ageParagraph = $('<p>').text(age + ' ans, ' + user.city);

                    userInfoTopDiv.append(nameHeading).append(ageParagraph);

                    let userInfoBottomDiv = $('<div>').addClass('userInfoBottom');
                    let genderLocationDiv = $('<div>').addClass('location').html('<i class="fa-solid fa-venus-mars"></i> ' + user.gender);
                    let attractionLocationDiv = $('<div>').addClass('location').html('<i class="fa-solid fa-fire"></i> ' + user.attraction);
                    userInfoBottomDiv.append(genderLocationDiv).append(attractionLocationDiv);
                    userInfoBottomDiv.append($('<div>').addClass('superflux').html('<i class="fa-solid fa-location-dot"></i> 5 km'));
                    userInfoBottomDiv.append($('<div>').addClass('superflux').html('<i class="fa-solid fa-ruler"></i> 160 cm'));
                    userInfoBottomDiv.append($('<div>').addClass('superflux').html('<i class="fa-solid fa-graduation-cap"></i> Bac +5 et plus'));
                    userInfoBottomDiv.append($('<div>').addClass('superflux').html("<i class='fa-solid fa-baby-carriage'></i> Pas d'enfant"));
                    userInfoBottomDiv.append($('<div>').addClass('superflux').html('<i class="fa-solid fa-baby"></i> Je veux des enfants'));


                    if (user.hasOwnProperty('hobbies')) {
                        let hobbiesArray = user.hobbies.split(',');

                        if (hobbiesArray.length > 0) {

                            hobbiesArray.forEach(function (hobby) {

                                switch (hobby.trim().toLowerCase()) {
                                    case 'dance':
                                        userInfoBottomDiv.append($('<div>').addClass('location').html('<i class="fa-regular fa-face-smile-wink"></i> Dance'));
                                        break;
                                    case 'cuisiner':
                                        userInfoBottomDiv.append($('<div>').addClass('location').html('<i class="fa-solid fa-kitchen-set"></i> Cuisiner'));
                                        break;
                                    case 'game play':
                                        userInfoBottomDiv.append($('<div>').addClass('location').html('<i class="fa-solid fa-gamepad"></i> Game Play'));
                                        break;
                                    case 'manga':
                                        userInfoBottomDiv.append($('<div>').addClass('location').html('<i class="fa-solid fa-book-open"></i> Manga'));
                                        break;
                                    case 'skateboard':
                                        userInfoBottomDiv.append($('<div>').addClass('location').html('<i class="fa-solid fa-person-skating"></i> Skateboard'));
                                        break;
                                    default:
                                        userInfoBottomDiv.append($('<div>').addClass('location').html('<i class="fa-regular fa-face-smile-beam"></i> ' + hobby.trim()));
                                        break;
                                };
                            });
                        }
                    }



                    rightDiv.append(userInfoTopDiv).append(userInfoBottomDiv);

                    let divBtnDiv = $('<div>').addClass('divBtn');
                    let slideBtnDiv = $('<div>').addClass('slideBtn').html('<i class="fa-solid fa-xmark"></i> Non');
                    let slideBtnDiv2 = $('<div>').addClass('slideBtn').html('<i class="fa-solid fa-heart"></i> Oui');

                    slideBtnDiv.attr('data-slide', user.id);
                    slideBtnDiv.attr('data-want', false);
                    slideBtnDiv2.attr('data-slide', user.id);
                    slideBtnDiv2.attr('data-want', true);
                    slideBtnDiv2.click(function () {
                        let cardToRemove = $(this).closest('.card');
                        let uid = $(this).data('slide');
                        let want = $(this).data('want');
                        let option = want ? "accepted" : "refused";

                        $.ajax({
                            url: 'http://localhost/W-PHP-501-MAR-1-1-mymeetic-adonai.ouisol/',
                            type: 'POST',
                            data: { iud: uid, option: option },
                            success: function (response) {

                            },
                            error: function (xhr, status, error) {
                                console.error(error);
                            }
                        });

                        cardToRemove.animate({ opacity: 'hide', width: 'hide' }, 'slow', function () {
                            $(this).remove();
                        });
                    });
                    slideBtnDiv.click(function () {
                        let cardToRemove = $(this).closest('.card');
                        let uid = $(this).data('slide');
                        let want = $(this).data('want');
                        let option = want ? "accepted" : "refused";

                        $.ajax({
                            url: 'http://localhost/W-PHP-501-MAR-1-1-mymeetic-adonai.ouisol/',
                            type: 'POST',
                            data: { iud: uid, option: option },
                            success: function (response) {
                                if (response.success) {

                                } else {

                                }
                            },
                            error: function (xhr, status, error) {
                                console.error(error);
                            }
                        });

                        cardToRemove.animate({ opacity: 'hide', width: 'hide' }, 'slow', function () {
                            $(this).remove();
                        });
                    });

                    divBtnDiv.append(slideBtnDiv);
                    divBtnDiv.append(slideBtnDiv2);

                    divBtnDiv.append('<a href="./profile?uid=' + user.id + '"><i class="fa-solid fa-eye"></i> Voir</a>');

                    rightDiv.append(divBtnDiv);
                    cardDiv.append(leftDiv).append(rightDiv);
                    $('#cards').append(cardDiv);
                });
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });

    });


    // Update section

    $('#updateForm').submit(function (event) {
        event.preventDefault();

        let firstname = $('#firstname');
        let lastname = $('#lastname');
        let email = $('#email');
        let city = $('#city');
        let actualPsw = $('#actualPassword');
        let psw = $('#password');
        let cPsw = $('#confPassword');
        let btn = $('#updateBtn').attr('name');

        $.fn.verifyContent(firstname)
        $.fn.verifyContent(lastname)
        $.fn.verifyContent(city)
        $.fn.verifyContent(email)
        $.fn.verifyContent(actualPsw)
        let verif;
        let data;
        if (cPsw.val() != "" && psw.val() != "") {
            $.fn.verifyContent(psw)
            $.fn.verifyContent(cPsw)

            verif = ($.fn.verifyContent(firstname) && $.fn.verifyContent(lastname) && $.fn.verifyContent(city) && $.fn.verifyContent(email) && $.fn.verifyContent(psw) && $.fn.verifyContent(cPsw) && $.fn.verifyContent(actualPsw))
            data = { email: email.val(), psw: psw.val(), cPsw: cPsw.val(), firstname: firstname.val(), lastname: lastname.val(), actualPsw: actualPsw.val(), city: city.val(), update: btn }
        } else {
            verif = ($.fn.verifyContent(firstname) && $.fn.verifyContent(lastname) && $.fn.verifyContent(city) && $.fn.verifyContent(email) && $.fn.verifyContent(actualPsw))
            data = { email: email.val(), firstname: firstname.val(), lastname: lastname.val(), actualPsw: actualPsw.val(), city: city.val(), psw: '', cPsw: '', update: btn }
        }

        if (verif) {

            $.ajax({
                url: 'http://localhost/W-PHP-501-MAR-1-1-mymeetic-adonai.ouisol/update',
                type: 'POST',
                data: data,
                success: function (response) {
                    if (response.success) {

                        window.location.href = 'logout';

                    } else {
                        $("#response").text(response.message)
                        $("#response").css({ "color": "red" })
                        $("#response").show()

                    }
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });

        }
    });


    // Register section

    $('#registerForm').submit(function (event) {
        event.preventDefault();

        let firstname = $('#firstname');
        let lastname = $('#lastname');
        let gender = $('#gender');
        let attraction = $('#attraction');
        let birthday = $('#birthday');
        let email = $('#email');
        let city = $('#city');
        let psw = $('#password');
        let cPsw = $('#confPassword');
        let btn = $('#registerBtn').attr('name');

        $.fn.verifyContent(firstname)
        $.fn.verifyContent(lastname)
        $.fn.verifyContent(gender)
        $.fn.verifyContent(birthday)
        $.fn.verifyContent(city)
        $.fn.verifyContent(email)
        $.fn.verifyContent(psw)
        $.fn.verifyContent(cPsw)

        if ($.fn.verifyContent(firstname) && $.fn.verifyContent(lastname) && $.fn.verifyContent(gender) && $.fn.verifyContent(birthday) && $.fn.verifyContent(city) && $.fn.verifyContent(email) && $.fn.verifyContent(psw) && $.fn.verifyContent(cPsw)) {

            $.ajax({
                url: 'http://localhost/W-PHP-501-MAR-1-1-mymeetic-adonai.ouisol/welcome',
                type: 'POST',
                data: { email: email.val(), psw: psw.val(), cPsw: cPsw.val(), firstname: firstname.val(), lastname: lastname.val(), gender: gender.val(), attraction: attraction.val(), birthday: birthday.val(), city: city.val(), register: btn },
                success: function (response) {
                    if (response.success) {

                        window.location.href = 'profile';
                    } else {
                        $("#response").text(response.message)
                        $("#response").css({ "color": "red" })
                        $("#response").show()

                    }
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        }
    });

    $('#password').on('input', function () {
        let password = $(this).val();
        $('.password-criteria ').show();

        let isLengthValid = password.length >= 8 && password.length <= 50;
        let isMajValid = /[A-Z].*[A-Z]/.test(password);
        let isMinValid = /[a-z].*[a-z]/.test(password);
        let isNumericValid = password.match(/\d/g) ? password.match(/\d/g).length >= 2 : false;
        let isCharsValid = /[!@#$%^&*()-_=+{};:,<.>].*[!@#$%^&*()-_=+{};:,<.>]/.test(password);

        $('.password-criteria .length').css('color', isLengthValid ? 'green' : 'red');
        $('.password-criteria .numeric').css('color', isNumericValid ? 'green' : 'red');
        $('.password-criteria .maj').css('color', isMajValid ? 'green' : 'red');
        $('.password-criteria .min').css('color', isMinValid ? 'green' : 'red');
        $('.password-criteria .chars').css('color', isCharsValid ? 'green' : 'red');
        if (isLengthValid && isNumericValid && isMajValid && isMinValid && isCharsValid) {
            $('.password-criteria').hide();
        } else {
            $('.password-criteria').show();
        }

        let cf = $('#confPassword');
        let pass = $('#password');

        if (cf.val() == pass.val()) {
            cf.css({ "border": "1px solid black", "background": "white" });
        } else {
            cf.css({ "border": "1px solid red", "background": "rgba(255,0,0, .2)" });
        }

        if ($('#confPassword').val() != $('#password').val()) {
            $('#updateBtn').hide()
        } else {
            $('#updateBtn').show()

        }

        if (password == "") {
            $('.password-criteria').hide();
        }
    });

    $('#confPassword').on("input", function () {
        let cf = $('#confPassword');
        let pass = $('#password');

        if (cf.val() == pass.val()) {
            cf.css({ "border": "1px solid black", "background": "white" });
        } else {
            cf.css({ "border": "1px solid red", "background": "rgba(255,0,0, .2)" });
        }

        if ($('#confPassword').val() != $('#password').val()) {
            $('#updateBtn').hide()
        } else {
            $('#updateBtn').show()

        }
    });

    $("#email").on("input", function () {
        let mail = $("#email");
        let isMail = /^[\w\.-]+@[a-zA-Z\d\.-]+\.[a-zA-Z]{2,}$/.test(mail.val());
        if (isMail) {
            mail.css({ "border": "1px solid white", "background": "white" });
        } else {
            mail.css({ "border": "1px solid red", "background": "rgba(255,0,0, .2)" });
        }
    });

    $("#birthday").on("change", () => {
        let selectedDate = $("#birthday").val();
        let dateOfBirth = new Date(selectedDate);

        let today = new Date();


        let age = today.getFullYear() - dateOfBirth.getFullYear();

        if (age >= 18 && age <= 70) {
            $("#ageVerif").hide()
            $("#birthday").css({ "border": "1px solid white", "background": "white" });
        } else {
            $("#ageVerif").show()
            $("#ageVerif").css({ "color": "red" });
            $("#birthday").css({ "border": "1px solid red", "background": "rgba(255,0,0, .2)" });



        }


    });

    // Optimize section
    $("#optimizeForm").submit((event) => {
        event.preventDefault();
        let loisirs = {}
        if ($("#dance").prop("checked")) {
            loisirs.dance = 1
        }
        if ($("#skateboard").prop("checked")) {
            loisirs.skateboard = 2
        }
        if ($("#manga").prop("checked")) {
            loisirs.manga = 3
        }
        if ($("#game").prop("checked")) {
            loisirs.gameplay = 4
        }
        if ($("#cuisiner").prop("checked")) {
            loisirs.cuisiner = 5
        }
        loisirs.loisir = "Optimize"


        if (Object.keys(loisirs).length >= 2) {

            $.ajax({
                url: 'http://localhost/W-PHP-501-MAR-1-1-mymeetic-adonai.ouisol/profile',
                type: 'POST',
                data: loisirs,
                success: function (response) {
                    if (response.success) {

                        window.location.href = 'profile';

                    } else {
                        $("#response").text(response.message)
                        $("#response").css({ "color": "red" })
                        $("#response").show()

                    }
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });

        } else {
            $("#responseError").text("Select at least 1 value")
            $("#responseError").css({ "background": "red", "color": "white" })
            $("#responseError").show()
        }
    })


    $("#dance").change((event) => {
        if (event.target.checked || $("#skateboard").prop("checked") || $("#manga").prop("checked") || $("#game").prop("checked") || $("#cuisiner").prop("checked")) {

            $("#optimizeBtn").css({ "visibility": "visible" })
        } else {
            $("#optimizeBtn").css({ "visibility": "hidden" })

        }
    });

    $("#skateboard").change((event) => {
        if (event.target.checked || $("#dance").prop("checked") || $("#manga").prop("checked") || $("#game").prop("checked") || $("#cuisiner").prop("checked")) {

            $("#optimizeBtn").css({ "visibility": "visible" })
        } else {
            $("#optimizeBtn").css({ "visibility": "hidden" })

        }
    });

    $("#manga").change((event) => {
        if (event.target.checked || $("#skateboard").prop("checked") || $("#dance").prop("checked") || $("#game").prop("checked") || $("#cuisiner").prop("checked")) {

            $("#optimizeBtn").css({ "visibility": "visible" })
        } else {
            $("#optimizeBtn").css({ "visibility": "hidden" })

        }
    });
    $("#game").change((event) => {
        if (event.target.checked || $("#skateboard").prop("checked") || $("#manga").prop("checked") || $("#dance").prop("checked") || $("#cuisiner").prop("checked")) {

            $("#optimizeBtn").css({ "visibility": "visible" })
        } else {
            $("#optimizeBtn").css({ "visibility": "hidden" })

        }
    });

    $("#cuisiner").change((event) => {
        if (event.target.checked || $("#skateboard").prop("checked") || $("#manga").prop("checked") || $("#game").prop("checked") || $("#dance").prop("checked")) {

            $("#optimizeBtn").css({ "visibility": "visible" })
        } else {
            $("#optimizeBtn").css({ "visibility": "hidden" })

        }
    });

    $("#profil").change(function () {
        const file = $("#profil")[0].files;
        let fileName = file[0].name;
        let allowedExtension = ['jpg', 'jpeg', 'png'];
        let extension = fileName.split(".").pop();
        if (allowedExtension.includes(extension)) {
            let formData = new FormData();
            formData.append('profil', file[0]);
            $.ajax({
                url: 'http://localhost/W-PHP-501-MAR-1-1-mymeetic-adonai.ouisol/update',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    window.location.href = 'update';
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // Gérer les erreurs
                    console.error("Erreur lors de l'envoi de la requête : ", response);
                }
            });
        }
    });


    $(".slideBtn").each(function (index, element) {
        $(element).click(() => {

            let cardToRemove = $(element).closest('.card');
            let uid = $(this).data('slide');
            let want = $(this).data("want")
            let option = ""
            if (want) {

                option = "accepted";
            } else {
                option = "refused"

            }

            $.ajax({
                url: 'http://localhost/W-PHP-501-MAR-1-1-mymeetic-adonai.ouisol/',
                type: 'POST',
                data: { iud: uid, option: option },
                success: function (response) {

                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });


            cardToRemove.animate({ opacity: 'hide', width: 'hide' }, 'slow', function () {
                $(this).remove();
            });

        });
    });

    $(".invitation").each(function (index, element) {
        $(element).click(() => {


            let uid = $(element).data('slide');
            let want = $(element).data("want")
            let option = ""

            if (want) {

                option = "accepted";
            } else {
                option = "refused"

            }


            $.ajax({
                url: 'http://localhost/W-PHP-501-MAR-1-1-mymeetic-adonai.ouisol/',
                type: 'POST',
                data: { iud: uid, option: option },
                success: function (response) {
                    if (response.success) {
                        window.location.href = 'homepage';
                    }
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });



        });
    });



    $.fn.verifyContent = function (input) {
        if (input.val().trim() == "") {
            input.css({ "border": "1px solid red" })
            input.css({ "background": "rgba(255,0,0, .2)" })
            error = false
        } else {
            input.css({ "border": "1px solid white" })
            input.css({ "background": "whithe" })
            error = true

        }
        return error
    }
    let count = 0;

    $("#dropdown").on("click", () => {
        if (count === 0) {
            $(".dropdown").css({ "height": "19em", "padding": "1em", "transition": "all .5s .1s ease" });
            count = 1;
        } else {
            $(".dropdown").css({ "height": "0", "padding": "0", "transition": "all .5s .1s ease" });
            count = 0;
        }
    });

    $("#filterBtn").on("click", () => {
        $(".dropdown").css({ "height": "0", "padding": "0", "transition": "all .5s .1s ease" });
        count = 0;
    })
    let url = "";
    $("#msg").on("input", function () {
        let msg = url.split("=")[1];
    });

    $(".context").each(function (index, element) {
        $(element).click(function (event) {
            $(".msgRight").css({ "visibility": "visible" })
            event.preventDefault();
            $('.screen').empty()
            url = $(element).attr("href");

            let msg = url.split("=")[1];
            $('#msgBtn').attr('data-msg', msg);
            const sender = $("#msgBtn").data("msg");
            $.ajax({
                url: "http://localhost/W-PHP-501-MAR-1-1-mymeetic-adonai.ouisol/messages",
                method: "POST",
                data: { msg: msg, select: 'select' },
                success: function (response) {
                    if (response.success) {

                        $.each(response.message, function (index, message) {
                            if (message.me_id == sender) {
                                let div = $('<div>').addClass('sender').text(message.msg);

                                $('.screen').append(div)
                            } else {
                                let div = $('<div>').addClass('me').text(message.msg);
                                $('.screen').append(div)


                            }
                            // console.log(message.msg);
                        });
                    }
                    else {
                        // console.log(response);
                    }

                },
                error: function (xhr, status, error) {

                    console.error("Erreur lors de la requête AJAX :", error);
                }
            });
        });
    });

    $('#messageForm').submit(function (event) {
        event.preventDefault();

        let msg = $('#msg').val();
        let btn = $('#msgBtn').attr('name');
        const sender = url.split("=")[1];
        console.log(sender);
        $('#msg').val('');

        if (msg != "") {
            $.ajax({
                url: 'http://localhost/W-PHP-501-MAR-1-1-mymeetic-adonai.ouisol/messages',
                type: 'POST',
                data: { msg: msg, sender: sender, send: btn },
                success: function (response) {
                    if (response.success) {
                        console.log(response);
                        $('.screen').empty()
                        $.each(response.message, function (index, message) {
                            if (message.me_id == sender) {
                                let div = $('<div>').addClass('sender').text(message.msg);
                                $('.screen').append(div)
                            } else {
                                let div = $('<div>').addClass('me').text(message.msg);
                                $('.screen').append(div)


                            }
                            // console.log(message.msg);
                        });

                    } else {
                        // console.log(response);

                    }
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        }


    });

    $.fn.fetchMessages = () => {
        let currentUrl = window.location.href;
        if (currentUrl === "http://localhost/W-PHP-501-MAR-1-1-mymeetic-adonai.ouisol/messages") {
            let sender = $("#msgBtn").data("msg")
            if ($.trim(url) !== '' && $.trim(sender) !== '') {
                let msg = url.split("=")[1];
                
                if (msg == sender) {
    
                    $.ajax({
                        url: "http://localhost/W-PHP-501-MAR-1-1-mymeetic-adonai.ouisol/messages",
                        method: "POST",
                        data: { msg: msg, select: 'select' },
                        success: function (response) {
                            if (response.success) {
                                // console.log(response);
                                $('.screen').empty()
                                $.each(response.message, function (index, message) {
                                    if (message.me_id == sender) {
                                        let div = $('<div>').addClass('sender').text(message.msg);
                                        $('.screen').append(div);
                                    } else {
                                        let div = $('<div>').addClass('me').text(message.msg);
                                        $('.screen').append(div);
                                    }
                                });
                            } else {
    
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error("Erreur lors de la requête AJAX :", error);
                        }
                    });
                } else {
                    console.log('nothing');
                    console.log(msg);
                    console.log(sender);
                }
            }
            

        }
    }

    // Exécuter la fonction toutes les 5 secondes
    setInterval($.fn.fetchMessages, 2000);

});

