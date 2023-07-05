<!-- add bottom js links here -->
<script src="js/script.js"></script>
<script src="js/aside.js"></script>
<script>
    $(document).ready(function(){
        $('main').children().each(function(){
            $(this).hide()
        })
        $('main').children().not('.fade').not('script').each(function(){
            $(this).fadeIn('slow')
        })
    })
</script>
<script src="js/chart.js"></script>


