$(document).ready(() => {
    const num1 = $('#num1')
    const num2 = $('#num2')
    const operator = $('#operator')

    //CAMBIA DATOS DE LA PANTALLA
    $('#input-1').on('change', function() {
        num1.val($(this).val())
    })

    $('#input-2').on('change', function() {
        num2.val($(this).val())
    })

    $('.operators').on('click', function() {
        const _this = $(this)
        if(!_this.hasClass('equals')) {
            operator.val(_this.text())
        }
    })

    //CALCULOS
    $('.equals').on('click', () => {
        let result

        const val1 = parseInt(num1.val())
        const val2 = parseInt(num2.val())
        
        if(isNaN(val1) || isNaN(val2)) {
            return
        }

        switch(operator.val()) {
            case '+':
                result = val1 + val2
                break
            
            case '-':
                result = val1 - val2
                break

            case '*':
                result = val1 * val2
                break
            
            case '/':
                result = val2 !== 0 ? val1 / val2 : 'Math Error: division by zero'
                break

            case '%':
                result = (val1 * val2) / 100
                break
        
            case '√':
                result = Math.sqrt(val1)
                break

            default:
                result = 'No se detecta operación a realizar'
        }

        $('#result').val(result)
    })
})