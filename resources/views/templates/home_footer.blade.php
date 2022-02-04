<script src="https://cdn.jsdelivr.net/npm/cleave.js@1.6.0/dist/cleave.min.js"></script>
<script>
    var cleave = new Cleave('.input-amount', {
        numeral: true,
        numeralThousandsGroupStyle: 'thousand'
    });
</script>
<script>
    var cleave = new Cleave('.fiat-amount', {
        numeral: true,
        numeralThousandsGroupStyle: 'thousand'
    });
</script>
<script src="{{ asset('home/js/rate.js') }}"></script>
