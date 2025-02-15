listenClick('#addAmountm', function () {
    $('#createAmountModal').modal('show').appendTo('body')
})
listenSubmit('#addPaymentForm', function (e) {
    e.preventDefault()
    let paymentType = $('#paymentType').val()

    if($('#totalAmount').val() == ''){
        displayErrorMessage('Please Enter Valid Amount')
        return false
    }

    let payloadData = {

        amount: $('#totalAmount').val(),

    }
    let amount = $('#totalAmount').val()
    let stripes = 'Stripe'
    let paypal = 'PayPal'
    let razorpay = 'Razorpay'
    let paytm = 'Paytm'
    let authorization = 'Authorize'
    let paystack = 'Paystack'
    let manually = 'Manually'

    let amountValue = parseFloat($('#amount').val())

    let arr = []
    i = 0

    $('.test .min_max').each(function () {
        arr[i++] = parseFloat($(this).attr('value'))
    })

    if (amountValue < arr[0] || amountValue > arr[1]) {
        displayErrorMessage('The amount should be between ' + arr[0] + ' to ' + arr[1])
        return false
    }

    if (paymentType == manually) {
        $('#paypalInit').attr('disabled',true)
        $.ajax({
            url: route('user.manually-add-payment'),
            type: 'POST',
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function (result) {
                if (result.success) {
                    setTimeout(function () {
                        Turbo.visit(route('user.deposit-transaction.index'))
                    }, 1500)
                    displaySuccessMessage(result.message)
                    $('#paypalInit').attr('disabled',false)
                }
            },
            error: function (result) {
                displayErrorMessage(result.responseJSON.message)
                $('#paypalInit').attr('disabled',false)
            },
        })
    }
    
    if (paymentType == paypal) {
        $.ajax({
            type: 'GET',
            data: { 'payloadData': amount },
            url: route('user.paypal.init'),
            success: function (result) {
                if (result.status == 200) {
                    let redirectTo = ''
                    location.href = result.link
                    // $.each(result.result.links, function (key, val) {
                    //     if (val.rel == 'approve') {
                    //         redirectTo = val.href
                    //     }
                    // })
                }
            },
            error: function (result) {
                displayErrorMessage(result.responseJSON.message)
            },

        })
        // paypal.Buttons({
        //     // Call your server to set up the transaction
        //     createOrder: function(data, actions) {
        //         return fetch('/paypal-onboard', {
        //             headers: {
        //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //             },
        //             method: 'POST',
        //             body:JSON.stringify({
        //                 'param_1_id': 1,
        //                 'user_id' : 1,
        //                 'amount' : $("#paypalAmount").val(),
        //             })
        //         }).then(function(res) {
        //             //res.json();
        //             return res.json();
        //         }).then(function(orderData) {
        //             //console.log(orderData);
        //             return orderData.id;
        //         });
        //     },
        //
        //     // Call your server to finalize the transaction
        //     onApprove: function(data, actions) {
        //         return fetch('/api/paypal/order/capture' , {
        //             method: 'POST',
        //             body :JSON.stringify({
        //                 orderId : data.orderID,
        //                 payment_gateway_id: $("#payapalId").val(),
        //                 user_id: "{{ 1 }}",
        //             })
        //         }).then(function(res) {
        //             // console.log(res.json());
        //             return res.json();
        //         }).then(function(orderData) {
        //
        //             // Successful capture! For demo purposes:
        //             //  console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
        //             var transaction = orderData.purchase_units[0].payments.captures[0];
        //             iziToast.success({
        //                 title: 'Success',
        //                 message: 'Payment completed',
        //                 position: 'topRight'
        //             });
        //         });
        //     }
        //
        // }).render('#paypal-button-container');

    }

    if (paymentType == stripes) {
        $.post(route('user.add-payment'), payloadData).done((result) => {

            if (typeof result.data == 'undefined') {
                displaySuccessMessage(result.message)
                setTimeout(function () {
                    Turbo.visit(route('subscription.index'))
                }, 3000)

                return true
            }
            let sessionId = result.data.sessionId
            stripe.redirectToCheckout({
                sessionId: sessionId,
            }).then(function (result) {
                $('.makePayment').attr('disabled', false)
                displaySuccessMessage(result.message)
            })
        }).catch(error => {
            $('.makePayment').attr('disabled', false)
            displayErrorMessage(error.responseJSON.message)
        })
    }
    if (paymentType == razorpay) {
        $.ajax({
            type: 'POST',
            url: route('user.razorpay.init'),
            data: { 'payloadData': amount },
            success: function (result) {
                if (result.success) {

                    let { id, amount, name, email, contact } = result.data

                    options.amount = amount
                    options.order_id = id

                    let razorPay = new Razorpay(options)
                    razorPay.open()
                    razorPay.on('payment.failed', storeFailedPayment)
                }
            },
            error: function (result) {
            },
            complete: function () {
            },
        })
    }

    if (paymentType == paytm) {
        window.location.replace(
            route('paytm.init', { 'payloadData': amount }))
    }
    if (paymentType == authorization) {
        window.location.replace(route('user.authorize.init',
            { 'payloadData': amount }))
    }
    if (paymentType == paystack) {

        window.location.replace(
            route('user.paystack.init', { 'payloadData': amount }))
    }
})

function storeFailedPayment (response) {
    $.ajax({
        type: 'POST',
        url: route('razorpay.failed'),
        data: {
            data: response,
        },
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message)
            }
        },
        error: function () {
        },
    })
}

listenKeyup('#amount', function () {

    let amount = $(this).val()
    if (isEmpty(amount)) {
        $('#totalAmount').val(0)
    } else {
        if ($('#taxValuePercent').length == 1) {
            let taxRate = $('#taxValuePercent').attr('value')
            let tax = amount * taxRate / 100
            let total = parseFloat(amount) + parseFloat(tax)

            $('#totalAmount').val(total)
        } else {
            let taxRate = $('#taxValueFixed').attr('value')
            let tax = parseFloat(amount) + parseFloat(taxRate)

            $('#totalAmount').val(tax)
        }
    }
})
