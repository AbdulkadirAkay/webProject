let cardsService = {
    currentDeck: null,
    currentDeckId: 0,
    user: null,
    index: 0,
    selectedFolderId: 0,
    renaming: false,
    userToken: null,


    serve: function() {
        let token = localStorage.getItem('token');
        cardsService.userToken = JSON.parse(token).token

        if (token) {
    
          try {
            let base64Url = token.split('.')[1];      //function for getting data from JWT key
            let base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
            let jsonPayload = decodeURIComponent(atob(base64).split('').map(function (c) {
              return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
            }).join(''));
            parsedUser = JSON.parse(jsonPayload);
            cardsService.user = parsedUser
          }
    
          catch(error){
            console.error("Invalid Token");
    
            setTimeout(()=>{userService.logout();}, 3000)
          }
        } else {
          console.log("Token Missing")
        }
    
        cardsService.getFolders()
        
        $("#newDeckName").hide()
        
        $(".nameSurname").html(`${cardsService.user.first_name} ${cardsService.user.last_name}`)

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

        $("#deleteDeckBttn").click(function() {
            console.log(cardsService.currentDeckId)
            $.ajax({
                url: `deleteFolderDeckByDeck/${cardsService.currentDeckId}`,
                type: "DELETE",
                success: function(res) {
                    $.ajax({
                        url: `deleteDeck/${cardsService.currentDeckId}`,
                        type: "DELETE",
                        beforeSend: function (xhr) {
                            xhr.setRequestHeader('Authorization', cardsService.userToken);
                        },
                        success: function(res) {
                            window.location.reload()
                        }
                    })
                }
            })
        })

        $("#createDeckBttn").click(function() {
            var values = []
            var pair = {}
            $('#cards .form-control').each(function(index) {
                if(index % 2 == 0) {
                    var id = 'question' // Get the label text
                    var value = $(this).val(); // Get the input value

                    pair[id] = value
                } else {
                    var id = 'answer' // Get the label text
                    var value = $(this).val(); // Get the input value
                    
                    pair[id] = value
                    values.push(pair)
                    pair = {}
                }
            });

            $.ajax({
                type: "POST",
                url: "addDeck",
                data: JSON.stringify({
                    deck_name: $(".deckNameInput").val()
                }),
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('Authorization', cardsService.userToken);
                },
                contentType: "application/json",
                dataType: "json",

                success: function(res) {
                    $.ajax({
                        type: "POST",
                        url: "addFolderDeck",
                        data: JSON.stringify({
                            deck_id: res.id,
                            folder_id: cardsService.selectedFolderId
                        }),
                        beforeSend: function (xhr) {
                            xhr.setRequestHeader('Authorization', cardsService.userToken);
                        },
                        contentType: "application/json",
                        dataType: "json",

                        success: function(res1) {
                            console.log('done')
                        }
                    })

                    for(let el of values) {
                        $.ajax({
                            type: "POST",
                            url: "addCard",
                            data: JSON.stringify({
                                question: el.question,
                                answer: el.answer,
                                deck_id: res.id
                            }),
                            contentType: "application/json",
                            dataType: "json",
                            beforeSend: function (xhr) {
                                xhr.setRequestHeader('Authorization', cardsService.userToken);
                            },
    
                            success: function(res2) {
                                console.log('done')
                            }
                        })
                    }
                }
                
            })
        })
    
        $("#logOut").click(function() {
            cardsService.logout()
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

        $("#deleteFolderBttn").click(function() {
            cardsService.deleteFolder(cardsService.selectedFolderId)
            cardsService.reloadFolders()
        })

        $("#renameFolderBttn").click(function() {
            const newName = $("#newFolderNameInput").val();

            cardsService.renameFolder(cardsService.selectedFolderId, newName)
        })

        $("#deleteCardBttn").click(function() {
            cardsService.deleteCard(cardsService.currentDeck[cardsService.index].id)
        })

        $("#renameDeck").click(function() {
            cardsService.renaming = !cardsService.renaming

            if(cardsService.renaming) {
                $("#deckName").hide()
                $("#newDeckName").show()
                $("#renameDeck").html("Save")
            } else {
                $("#deckName").show()
                $("#newDeckName").hide()
                $("#renameDeck").html("Rename")

                const newName = $("#newDeckNameInput").val()

                cardsService.renameDeck(cardsService.currentDeck.idId, newName)
                cardsService.renaming = false
            }
        })

        $("#createFolderBttn").click(function() {
            let folder_name = $("#folderName").val()
            
            $.ajax({
                type: "POST",
                url: "addFolder",
                data: JSON.stringify({
                    folder_name: folder_name,
                    user_id: cardsService.user.id
                }),
                contentType: "application/json",
                dataType: "json",
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('Authorization', cardsService.userToken);
                },

                success: function(res) {
                    $(".folderSection").append(`
                        <div class="folder-head-${res.id}">
                            <p class="folderTitle">${res.folder_name}</p>
                            <button type="button" onclick="cardsService.selectedFolderId = ${res.id}" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteFolder">Delete Folder</button>
                            <button onclick="cardsService.selectedFolderId = ${res.id}" type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#renameFolder">Rename Folder</button>
                        </div>
                        <div id="folder-${res.id}" class = "folder">
                            <div data-bs-toggle="modal" data-bs-target="#createDeck" id="addCard" class = "card">
                                <button style="border: none; width: 100%" onclick="cardsService.selectedFolderId = ${folder.id}">+</button>
                            </div>
                        </div>
                    `)
                }
            })
        })

        $("#updateUserBttn").click(function() {
            $("#updateUser").validate({
                rules: {
                    firstName: {
                        required: true,
                    },
                    lastName: {
                        required: true,
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    passwordHash: {
                        required: true,
                        minlength: 8
                    }
                },
    
                messages: {
                    email: {
                        required: "Please enter your Email!",
                        email: "Enter valid Email!"
                    },
                    passwordHash: {
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
                    let user = JSON.stringify({
                        first_name: data.firstName,
                        last_name: data.lastName,
                        email: data.email,
                        password_hash: data.passwordHash
                    })

                    cardsService.updateProfile(user)
                }
            })
        })
    },

    getFolders: function() {
        $.ajax({
            type: "GET",
            url: `getFoldersByUser/${cardsService.user.id}`,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('Authorization', cardsService.userToken);
            },
            
    
            success: function(res) {

                for(let folder of res) {
                    $(".folderSection").append(`
                        <div class="folder-head-${folder.id}">
                            <p class="folderTitle">${folder.folder_name}</p>
                            <button type="button" onclick="cardsService.selectedFolderId = ${folder.id}" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteFolder">Delete Folder</button>
                            <button type="button" onclick="cardsService.selectedFolderId = ${folder.id}" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#renameFolder">Rename Folder</button>
                        </div>
                        <div id="folder-${folder.id}" class = "folder">
                            <div data-bs-toggle="modal" data-bs-target="#createDeck" id="addCard" class = "card">
                                <button style="border: none; width: 100%" onclick="cardsService.selectedFolderId = ${folder.id}">+</button>
                            </div>
                        </div>
                    `)

                    $.ajax({
                        type: "GET",
                        url: `getDecksByFolder/${folder.id}`,
                        beforeSend: function (xhr) {
                            xhr.setRequestHeader('Authorization', cardsService.userToken);
                        },

                        success: function(res) {
                            for(let deck of res) {
                                $(`#folder-${folder.id}`).prepend(`
                                    <div class="card" onclick="cardsService.setModal(${deck.id}, '${deck.deck_name}')" data-bs-toggle="modal" data-bs-target="#deck">
                                        ${deck.deck_name}
                                    </div>
                                `)
                            }
                        }
                    })
                }
            }
        })
    },

    reloadFolders: function() {
        $(".folderSection").html("")
        cardsService.getFolders()
    },


    setModal: function(deckId, deck_name) {
        $("#deckName").html(`${deck_name}`)

        $.ajax({
            type: "GET",
            url: `getCardsByDeck/${deckId}`,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('Authorization', cardsService.userToken);
            },
    
            success: async function(res) {
                cardsService.currentDeck = res
                cardsService.currentDeckId = deckId
                cardsService.index = 0
  
                if(res?.length != 0) {
                    cardsService.displayCard()
                }
            }            
        })
    },

    displayCard: function() {
        $(".question").html("Question: " + cardsService.currentDeck[cardsService.index].question)
        $(".answer").html("Answer: " + cardsService.currentDeck[cardsService.index].answer)
        $(".answer").hide()
    },

    revealCard: function() {
        $(".answer").show()
    },

    nextCard: function() {
        if (cardsService.index < cardsService.currentDeck.length - 1) {
            cardsService.index += 1
            $(".question").html("Question: " + cardsService.currentDeck[cardsService.index].question)
            $(".answer").html("Answer: " + cardsService.currentDeck[cardsService.index].answer)
            $(".answer").hide()
        }
    },

    prevCard: function() {
        if (cardsService.index > 0) {
            cardsService.index -= 1
            $(".question").html("Question: " + cardsService.currentDeck[cardsService.index].question)
            $(".answer").html("Answer: " + cardsService.currentDeck[cardsService.index].answer)
            $(".answer").hide()
        }
    },

    logout: function() {
        window.location.replace('landing')
        localStorage.removeItem('user')
        localStorage.removeItem('token')
    },

    updateProfile: function(data) {
        $.ajax({
            type: "PUT",
            url: `update/${cardsService.user.id}`,
            data: data,
            contentType: "application/json",
            dataType: "json",
            beforeSend: function (xhr) {
                xhr.setRequestHeader('Authorization', cardsService.userToken);
            },

            success: function(res) {
                cardsService.logout()
            },

            error: function(XMLHttpRequest, textStatus, error) {
                cardsService.logout()
            }

        })
    },

    deleteFolder: function(id) {
        $.ajax({
            type: "DELETE",
            url: `deleteFolder/${id}`,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('Authorization', cardsService.userToken);
            },

            success: function(res) {
                console.log("Deleted successfully")
            },

            error: function(XMLHttpRequest, textStatus, error) {
                console.log(error)
            }
        })

        $.ajax({
            type: "DELETE",
            url: `deleteFolderDeckByFolder/${id}`,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('Authorization', cardsService.userToken);
            },

            success: function(res) {
                console.log("Deleted successfully")
            },

            error: function(XMLHttpRequest, textStatus, error) {
                console.log(error)
            }
        })
    },

    renameFolder: function(id, folderName) {
        $.ajax({
            type: "PUT",
            url: "updateFolder",
            data: JSON.stringify({
                id: id,
                folder_name: folderName
            }),
            contentType: "application/json",
            dataType: "json",
            beforeSend: function (xhr) {
                xhr.setRequestHeader('Authorization', cardsService.userToken);
            },

            success: function(res) {
                console.log("Renamed successfully")
                cardsService.reloadFolders()
            },

            error: function(XMLHttpRequest, textStatus, error) {
                console.log(error)
            }
        })
    },

    deleteCard: function(id) {
        $.ajax({
            type: "DELETE",
            url: `deleteCard/${id}`,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('Authorization', cardsService.userToken);
            },
            success: function(res) {
                console.log("Deleted card")
                window.location.reload()
            },

            error: function(XMLHttpRequest, textStatus, error) {
                console.log(error)
            }
        })
    },

    renameDeck: function(id, name) {
        $.ajax({
            type: "PUT",
            url: "updateDeck",
            data: JSON.stringify({
                id: id,
                deck_name: name
            }),
            contentType: "application/json",
            dataType: "json",
            beforeSend: function (xhr) {
                xhr.setRequestHeader('Authorization', cardsService.userToken);
            },

            success: function(res) {
                console.log("Successfully Renamed")
            },

            error: function(XMLHttpRequest, textStatus, error) {
                console.log(error)
            }
        })
    }
}
