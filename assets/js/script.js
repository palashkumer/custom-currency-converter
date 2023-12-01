document.addEventListener('DOMContentLoaded', function () {
    // Fetch currency options from the API
    fetch('https://open.er-api.com/v6/latest')
        .then(response => response.json())
        .then(data => {
            const currencies = Object.keys(data.rates);
            const fromCurrencySelect = document.getElementById('from');
            const toCurrencySelect = document.getElementById('to');

            currencies.forEach(currency => {
                const option = document.createElement('option');
                option.value = currency;
                option.text = currency;
                fromCurrencySelect.add(option.cloneNode(true));
                toCurrencySelect.add(option);
            });
        });

    document.getElementById('convert-btn').addEventListener('click', function () {
        var amount = document.getElementById("amount").value;
        var fromCurrency = document.getElementById("from").value;
        var toCurrency = document.getElementById("to").value;

        // AJAX request
        jQuery.ajax({
            type: 'POST',
            url: cc_ajax_object.ajax_url,
            data: {
                action: 'convert_currency',
                amount: amount,
                fromCurrency: fromCurrency,
                toCurrency: toCurrency
            },
            success: function (response) {
                document.getElementById("result").innerHTML = "Converted Amount: " + response.data;
            },
            error: function (error) {
                console.error('Error:', error);
            }
        });
    });
});
