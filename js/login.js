$(document).ready(function() {
    $(".registration").hide()

    $("#showReg").click(function() {
        $(".login").hide()
        $(".registration").show()

        return false
    })

    $("#showLogin").click(function() {
        $(".login").show()
        $(".registration").hide()

        return false
    })

    $("#logUserIn").click(function() {
        $("#login-box").validate({
            rules: {
                emailLogin: {
                    required: true,
                    email: true
                },
                passwordLogin: {
                    required: true,
                    minlength: 8
                }
            },

            messages: {
                emailLogin: {
                    required: "Please enter your Email!",
                    email: "Enter valid Email!"
                },
                passwordLogin: {
                    required: "Please enter your Password!",
                    minlength: "Password needs to be at least 8 characters long!"
                }
            },

            submitHandler: function(form) {
                let data = Object.fromEntries((new FormData(form)).entries());
                let user = {
                    email: data.emailLogin,
                    password_hash: data.passwordLogin
                }
                
                $.ajax({
                    type: "POST",
                    url: "login",
                    data: JSON.stringify(user),
                    contentType: "application/json",
                    dataType: "json",

                    success: function(data) {
                        localStorage.setItem('token', JSON.stringify(data))

                        window.location.replace('home')
                    },

                    error: function() {
                        console.log("Login Failed")
                    }
                })
            }
        })
    })


    $("#regUser").click(function() {
        $("#reg-box").validate({
            rules: {
                firstName: {
                    required: true,
                },
                lastName: {
                    required: true,
                },
                regEmail: {
                    required: true,
                    email: true
                },
                regPass: {
                    required: true,
                    minlength: 8
                }
            },

            messages: {
                regEmail: {
                    required: "Please enter your Email!",
                    email: "Enter valid Email!"
                },
                regPass: {
                    required: "Please enter your Password!",
                    minlength: "Password needs to be at least 8 characters long!"
                },
                firstName: {
                    required: "Please enter your First Name"
                },
                lastName: {
                    required: "Please enter your Last Name"
                }
            },

            submitHandler: function(form) {
                let data = Object.fromEntries((new FormData(form)).entries());
                let user = {
                    email: data.regEmail,
                    password_hash: data.regPass,
                    first_name: data.firstName,
                    last_name: data.lastName
                }
                
                $.ajax({
                    type: "POST",
                    url: "register",
                    data: JSON.stringify(user),
                    contentType: "application/json",
                    dataType: "json",

                    success: function(data) {
                        localStorage.setItem('user', JSON.stringify(data))
                        window.location.replace('rest/home')
                    },

                    error: function() {
                        console.log("Login Failed")
                    }
                })
            }
        })
    })

})