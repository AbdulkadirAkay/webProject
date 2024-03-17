$(document).ready(function() {
    $("#newCard").click(function() {
        const input = `
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Question</span>
                <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Answer</span>
                <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
            </div>
            `

        $("#cards").prepend(input)
    })

    $("#logOut").click(function() {
        window.location.replace('/web/')

        return false
    })

})