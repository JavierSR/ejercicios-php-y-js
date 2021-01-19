const sendForm = () => {
    const form = {
        firstName: $('#first-name'),
        lastName: $('#last-name'),
        dni: $('#dni'),
        email: $('#email'),
        languages: $('#languages')
    }

    $('.text-warning').remove()

    const sendingData = {}
    let isValidForm = true

    for (const key in form) {
        const element = form[key]
        const value = element.val()
        if (value.length) {
            sendingData[key] = value
        }
        else {
            element.parent().append('<p class="text-warning">Campo vacío</p>')
            isValidForm = false
        }
    }

    if(!isValidForm) {
        return
    }

    const resultElement = $('#result')

    $.ajax({
        type: 'POST',
        url: 'main.php',
        data: sendingData,
        dataType: 'json',
        success: (response) => {
            console.log(response)
            if(response) {
                resultElement.text(response.message)
                $('#programmers').text(response.data.programmersCount)

                const title = $('#title')
                title.removeClass()
                title.addClass(response.result ? 'text-success' : 'text-danger')
            }
        },
        error: (xhr, status) => {
            console.log('ERROR', xhr.responseText, status)
            resultElement.text('Ocurrió un error')
        }
    });
}