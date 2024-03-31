let cardsService = {
    currentDeck: null,
    index: 0,

    serve: function() {
        cardsService.getFolders()

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

        $("#reveal").click(function() {
            cardsService.revealCard()
        })

        $("#next").click(function() {
            console.log(cardsService.index)
            cardsService.nextCard()
        })

        $("#prev").click(function() {
            console.log(cardsService.index)
            cardsService.prevCard()
        })
    },

    getFolders: function() {
        $.ajax({
            type: "GET",
            url: "folders",
    
            success: function(res) {
                for(let folder of res) {
                    $(".folderSection").append(`
                        <p class = "folderTitle">${folder.name}</p>
                        <div id="folder-${folder.id}" class = "folder">
                            <div data-bs-toggle="modal" data-bs-target="#createDeck" id="addCard" class = "card">
                                +
                            </div>
                        </div>
                    `)
    
                    for(let deck of folder.decks) {
                        $(`#folder-${folder.id}`).prepend(`
                            <div class="card" onclick="cardsService.setModal(${folder.id}, ${deck.id})" data-bs-toggle="modal" data-bs-target="#deck">
                                ${deck.name}
                            </div>
                        `)
                    }
    
                }
            }
        })
    },

    setModal: function(folderId, deckId) {
        $.ajax({
            type: "GET",
            url: "folders",
    
            success: async function(res) {
                const folder = await res.find(folder => folder.id == folderId)
                const deck = await folder.decks.find(deck => deck.id == deckId)
                const cards = await deck.cards

                cardsService.currentDeck = cards
                cardsService.index = 0
    
                $("#deckName").html(`${deck.name}`)
  
                cardsService.displayCard()
            }            
        })
    },

    displayCard: function() {
        $(".question").html("Question: " + Object.keys(cardsService.currentDeck[0]))
        $(".answer").html("Answer: " + Object.values(cardsService.currentDeck[0]))
        $(".answer").hide()
    },

    revealCard: function() {
        $(".answer").show()
    },

    nextCard: function() {
        if (cardsService.index < cardsService.currentDeck.length - 1) {
            cardsService.index += 1
            $(".question").html("Question: " + Object.keys(cardsService.currentDeck[cardsService.index]))
            $(".answer").html("Answer: " + Object.values(cardsService.currentDeck[cardsService.index]))
            $(".answer").hide()
        }
    },

    prevCard: function() {
        if (cardsService.index > 0) {
            cardsService.index -= 1
            $(".question").html("Question: " + Object.keys(cardsService.currentDeck[cardsService.index]))
            $(".answer").html("Answer: " + Object.values(cardsService.currentDeck[cardsService.index]))
            $(".answer").hide()
        }
    }
}
