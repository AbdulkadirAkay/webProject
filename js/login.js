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
        window.location.replace("rest/home")

        return false
    })




})